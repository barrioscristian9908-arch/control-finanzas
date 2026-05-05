<?php
    class MovimientoModel{
        private $PDO;
        public function __construct()
        {
            require_once("c://xampp/htdocs/control_finanzas/config/database.php");
            $con = new db();
            $this->PDO = $con->conexion();
        }

        public function getMovimientos($usuario_id){

            $statement = $this->PDO->prepare(
                "SELECT 
                    m.id,
                    m.tipo,
                    m.monto,
                    m.fecha,
                    m.descripcion,
                    m.meta_id, -- 🔥 esto agregás
                    c.nombre AS categoria,
                    cu.nombre AS cuenta
                FROM movimientos m
                LEFT JOIN categorias c ON m.categoria_id = c.id
                LEFT JOIN cuentas cu ON m.cuenta_id = cu.id
                WHERE m.usuario_id = :id
                ORDER BY m.fecha DESC"
            );

            $statement->bindParam(":id", $usuario_id);
            $statement->execute();

            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getCuentas($usuario_id){
            $statement = $this->PDO->prepare("SELECT id, nombre, saldo FROM cuentas WHERE usuario_id = :id");
            $statement->bindParam(":id", $usuario_id);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getCategorias($usuario_id){
            $statement = $this->PDO->prepare("SELECT id, nombre FROM categorias WHERE usuario_id = :id");
            $statement->bindParam(":id", $usuario_id);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }

        public function insertMovimiento($usuario_id, $tipo, $monto, $cuenta_id, $categoria_id, $descripcion, $meta_id = null){

            $statement = $this->PDO->prepare(
                "INSERT INTO movimientos 
                (usuario_id, tipo, monto, cuenta_id, categoria_id, descripcion, meta_id)
                VALUES (:usuario_id, :tipo, :monto, :cuenta_id, :categoria_id, :descripcion, :meta_id)"
            );

            $statement->bindParam(":usuario_id", $usuario_id);
            $statement->bindParam(":tipo", $tipo);
            $statement->bindParam(":monto", $monto);
            $statement->bindParam(":cuenta_id", $cuenta_id);
            $statement->bindParam(":categoria_id", $categoria_id);
            $statement->bindParam(":descripcion", $descripcion);
            $statement->bindParam(":meta_id", $meta_id);

            $statement->execute();
            return $this->PDO->lastInsertId();
        }

        public function sumarSaldo($cuenta_id, $monto){

            $statement = $this->PDO->prepare(
                "UPDATE cuentas SET saldo = saldo + :monto WHERE id = :id"
            );

            $statement->bindParam(":monto", $monto);
            $statement->bindParam(":id", $cuenta_id);

            return $statement->execute();
        }

        public function restarSaldo($cuenta_id, $monto){

            $statement = $this->PDO->prepare(
                "UPDATE cuentas SET saldo = saldo - :monto WHERE id = :id"
            );

            $statement->bindParam(":monto", $monto);
            $statement->bindParam(":id", $cuenta_id);

            return $statement->execute();
        }

        public function getMovimiento($id){
            $statement = $this->PDO->prepare("SELECT * FROM movimientos WHERE id = :id");
            $statement->bindParam(":id", $id);
            $statement->execute();
            return $statement->fetch(PDO::FETCH_ASSOC);
        }

        public function deleteMovimiento($id){
            $statement = $this->PDO->prepare("DELETE FROM movimientos WHERE id = :id");
            $statement->bindParam(":id", $id);
            return $statement
            ->execute();
        }

        public function updateMovimiento($id, $tipo, $monto, $cuenta_id, $categoria_id, $descripcion){

            $statement = $this->PDO->prepare(
                "UPDATE movimientos 
                SET tipo = :tipo,
                    monto = :monto,
                    cuenta_id = :cuenta,
                    categoria_id = :categoria,
                    descripcion = :descripcion
                WHERE id = :id"
            );

            $statement->bindParam(":tipo", $tipo);
            $statement->bindParam(":monto", $monto);
            $statement->bindParam(":cuenta", $cuenta_id);
            $statement->bindParam(":categoria", $categoria_id);
            $statement->bindParam(":descripcion", $descripcion);
            $statement->bindParam(":id", $id);

            return $statement->execute();
        }


        // Para reportes
        public function getResumenPorFecha($usuario_id, $desde, $hasta){

            $sql = "SELECT 
                        DATE(fecha) as fecha,
                        SUM(CASE WHEN tipo = 'ingreso' THEN monto ELSE 0 END) as ingresos,
                        SUM(CASE WHEN tipo = 'egreso' THEN monto ELSE 0 END) as egresos
                    FROM movimientos
                    WHERE usuario_id = :usuario_id
                    AND fecha BETWEEN :desde AND :hasta
                    GROUP BY DATE(fecha)
                    ORDER BY fecha ASC";

            $stmt = $this->PDO->prepare($sql);

            $stmt->execute([
                ":usuario_id" => $usuario_id,
                ":desde" => $desde,
                ":hasta" => $hasta
            ]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getGastosPorCategoria($usuario_id, $desde, $hasta){

            $sql = "SELECT 
                COALESCE(c.nombre, 'Sin categoría') as categoria,
                SUM(m.monto) as total
            FROM movimientos m
            LEFT JOIN categorias c ON m.categoria_id = c.id
            WHERE m.usuario_id = :usuario_id
            AND m.tipo = 'egreso'
            AND m.meta_id IS NULL
            AND m.fecha BETWEEN :desde AND :hasta
            GROUP BY categoria
            ORDER BY total DESC";

            $stmt = $this->PDO->prepare($sql);

            $stmt->execute([
                ":usuario_id" => $usuario_id,
                ":desde" => $desde,
                ":hasta" => $hasta
            ]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getCuenta($cuenta_id, $usuario_id){

            $stmt = $this->PDO->prepare("
                SELECT * FROM cuentas 
                WHERE id = :id AND usuario_id = :usuario_id
            ");

            $stmt->bindParam(":id", $cuenta_id);
            $stmt->bindParam(":usuario_id", $usuario_id);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function beginTransaction(){
            $this->PDO->beginTransaction();
        }

        public function commit(){
            $this->PDO->commit();
        }

        public function rollBack(){
            $this->PDO->rollBack();
        }

        public function filtrar($usuario_id, $tipo, $cuenta_id, $categoria_id, $desde, $hasta){

            $query = "SELECT 
                m.*, 
                c.nombre AS cuenta, 
                cat.nombre AS categoria
            FROM movimientos m
            LEFT JOIN cuentas c ON m.cuenta_id = c.id
            LEFT JOIN categorias cat ON m.categoria_id = cat.id
            WHERE m.usuario_id = ?";

            $params = [$usuario_id];

            if($tipo){
                $query .= " AND m.tipo = ?";
                $params[] = $tipo;
            }

            if($cuenta_id){
                $query .= " AND cuenta_id = ?";
                $params[] = $cuenta_id;
            }

            if($categoria_id){
                $query .= " AND categoria_id = ?";
                $params[] = $categoria_id;
            }

            if($desde){
                $query .= " AND fecha >= ?";
                $params[] = $desde;
            }

            if($hasta){
                $query .= " AND fecha <= ?";
                $params[] = $hasta;
            }

            $query .= " ORDER BY fecha DESC";

            $stmt = $this->PDO->prepare($query);
            $stmt->execute($params);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

       
    }
?>
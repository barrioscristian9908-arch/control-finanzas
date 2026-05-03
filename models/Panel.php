<?php
    class PanelModel{
        private $PDO;
        public function __construct()
        {
            require_once("c://xampp/htdocs/control_finanzas/config/database.php");
            $con = new db();
            $this->PDO = $con->conexion();
        }

        public function getBalance($usuario_id){

            $stament = $this->PDO->prepare(
                "SELECT SUM(saldo) as total FROM cuentas WHERE usuario_id = :id"
            );

            $stament->bindParam(":id", $usuario_id);
            $stament->execute();

            $resultado = $stament->fetch(PDO::FETCH_ASSOC);

            return $resultado["total"] ?? 0;
        }

        public function getIngresos($usuario_id){
            $stament = $this->PDO->prepare(
                "SELECT SUM(monto) as total 
                FROM movimientos 
                WHERE tipo = 'ingreso' AND usuario_id = :id"
            );

            $stament->bindParam(":id", $usuario_id);
            $stament->execute();

            $resultado = $stament->fetch(PDO::FETCH_ASSOC);

            return $resultado["total"] ?? 0;
        }

        public function getEgresos($usuario_id){

            $stament = $this->PDO->prepare(
                "SELECT SUM(monto) as total 
                FROM movimientos 
                WHERE tipo = 'egreso' AND usuario_id = :id"
            );

            $stament->bindParam(":id", $usuario_id);
            $stament->execute();

            $resultado = $stament->fetch(PDO::FETCH_ASSOC);

            return $resultado["total"] ?? 0;
        }

        public function getTotalCuentas($usuario_id){

            $stament = $this->PDO->prepare(
                "SELECT COUNT(*) as total 
                FROM cuentas 
                WHERE usuario_id = :id"
            );

            $stament->bindParam(":id", $usuario_id);
            $stament->execute();

            $resultado = $stament->fetch(PDO::FETCH_ASSOC);

            return $resultado["total"] ?? 0;
        }

        public function getMovimientos($usuario_id){

            $stament = $this->PDO->prepare(
                "SELECT m.*, c.nombre as categoria, cu.nombre as cuenta
                FROM movimientos m
                LEFT JOIN categorias c ON m.categoria_id = c.id
                LEFT JOIN cuentas cu ON m.cuenta_id = cu.id
                WHERE m.usuario_id = :id
                ORDER BY m.fecha DESC
                LIMIT 5"
            );

            $stament->bindParam(":id", $usuario_id);
            $stament->execute();

            return $stament->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getMetas($usuario_id){

            $stament = $this->PDO->prepare(
                "SELECT 
                    m.id,
                    m.nombre,
                    m.monto_objetivo,
                    COALESCE(SUM(ma.monto), 0) as monto_actual,
                    (COALESCE(SUM(ma.monto), 0) / m.monto_objetivo) as progreso
                FROM metas m
                LEFT JOIN meta_aportes ma ON m.id = ma.meta_id
                WHERE m.usuario_id = :id
                GROUP BY m.id
                ORDER BY progreso DESC"
            );

            $stament->bindParam(":id", $usuario_id);
            $stament->execute();

            return $stament->fetchAll(PDO::FETCH_ASSOC);
        }
       
    }
?>
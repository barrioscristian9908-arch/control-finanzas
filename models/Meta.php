<?php
    class MetaModel{
        private $PDO;
        public function __construct()
        {
            require_once("c://xampp/htdocs/control_finanzas/config/database.php");
            $con = new db();
            $this->PDO = $con->conexion();
        }


        public function getMetas($usuario_id){

            $statement = $this->PDO->prepare(
                "SELECT 
                    m.id,
                    m.nombre,
                    m.monto_objetivo,
                    m.fecha_limite,
                    COALESCE(SUM(ma.monto), 0) as ahorrado
                FROM metas m
                LEFT JOIN meta_aportes ma ON ma.meta_id = m.id
                WHERE m.usuario_id = :usuario_id
                GROUP BY m.id
                ORDER BY m.id DESC"
            );

            $statement->bindParam(":usuario_id", $usuario_id);
            $statement->execute();

            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }

        public function insertMeta($usuario_id, $nombre, $monto_objetivo, $fecha_limite){

            $statement = $this->PDO->prepare(
                "INSERT INTO metas 
                (usuario_id, nombre, monto_objetivo, fecha_limite)
                VALUES (:usuario_id, :nombre, :monto_objetivo, :fecha_limite)"
            );

            $statement->bindParam(":usuario_id", $usuario_id);
            $statement->bindParam(":nombre", $nombre);
            $statement->bindParam(":monto_objetivo", $monto_objetivo);
            $statement->bindParam(":fecha_limite", $fecha_limite);

            return $statement->execute();
        }

        public function getMeta($id, $usuario_id){

            $stament = $this->PDO->prepare(
                "SELECT * 
                FROM metas 
                WHERE id = :id 
                AND usuario_id = :usuario_id
                LIMIT 1"
            );

            $stament->bindParam(":id", $id);
            $stament->bindParam(":usuario_id", $usuario_id);
            $stament->execute();

            return $stament->fetch(PDO::FETCH_ASSOC);
        }

        public function getAhorroMeta($meta_id, $usuario_id){

            $stament = $this->PDO->prepare(
                "SELECT COALESCE(SUM(ma.monto), 0) as total
                FROM meta_aportes ma
                INNER JOIN metas m ON m.id = ma.meta_id
                WHERE ma.meta_id = :meta_id
                AND m.usuario_id = :usuario_id"
            );

            $stament->bindParam(":meta_id", $meta_id);
            $stament->bindParam(":usuario_id", $usuario_id);
            $stament->execute();

            $resultado = $stament->fetch(PDO::FETCH_ASSOC);

            return $resultado["total"];
        }

        public function updateMeta($id, $nombre, $monto_objetivo, $fecha_limite){

            $statement = $this->PDO->prepare(
                "UPDATE metas 
                SET nombre = :nombre,
                    monto_objetivo = :monto_objetivo,
                    fecha_limite = :fecha_limite
                WHERE id = :id"
            );

            $statement->bindParam(":nombre", $nombre);
            $statement->bindParam(":monto_objetivo", $monto_objetivo);
            $statement->bindParam(":fecha_limite", $fecha_limite);
            $statement->bindParam(":id", $id);

            return $statement->execute();
        }

        public function metaEnUso($id, $usuario_id){

            $stament = $this->PDO->prepare(
                "SELECT COUNT(*) as total
                FROM meta_aportes ma
                INNER JOIN metas m ON m.id = ma.meta_id
                WHERE ma.meta_id = :id
                AND m.usuario_id = :usuario_id"
            );

            $stament->bindParam(":id", $id);
            $stament->bindParam(":usuario_id", $usuario_id);
            $stament->execute();

            $resultado = $stament->fetch(PDO::FETCH_ASSOC);

            return $resultado["total"] > 0;
        }

        public function deleteMeta($id){

            $statement = $this->PDO->prepare(
                "DELETE FROM metas WHERE id = :id"
            );

            $statement->bindParam(":id", $id);

            return $statement->execute();
        }

        public function insertAporte($meta_id, $monto, $movimiento_id){

            $stmt = $this->PDO->prepare(
                "INSERT INTO meta_aportes (meta_id, monto, movimiento_id)
                VALUES (:meta_id, :monto, :movimiento_id)"
            );

            $stmt->bindParam(":meta_id", $meta_id);
            $stmt->bindParam(":monto", $monto);
            $stmt->bindParam(":movimiento_id", $movimiento_id);

            return $stmt->execute();
        }

        public function getAportes($meta_id, $usuario_id){

            $stmt = $this->PDO->prepare(
                "SELECT ma.id, ma.monto, ma.fecha
                FROM meta_aportes ma
                INNER JOIN metas m ON ma.meta_id = m.id
                WHERE ma.meta_id = :meta_id
                AND m.usuario_id = :usuario_id
                ORDER BY ma.fecha DESC"
            );

            $stmt->bindParam(":meta_id", $meta_id);
            $stmt->bindParam(":usuario_id", $usuario_id);

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getAporte($id, $usuario_id){

            $stmt = $this->PDO->prepare(
                "SELECT ma.*, m.usuario_id 
                FROM meta_aportes ma
                INNER JOIN metas m ON ma.meta_id = m.id
                WHERE ma.id = :id AND m.usuario_id = :usuario_id
                LIMIT 1"
            );

            $stmt->bindParam(":id", $id);
            $stmt->bindParam(":usuario_id", $usuario_id);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function deleteAporte($id){

            $stmt = $this->PDO->prepare(
                "DELETE FROM meta_aportes WHERE id = :id"
            );

            $stmt->bindParam(":id", $id);

            return $stmt->execute();
        }
       
    }
?>
<?php
    class CuentaModel{
        private $PDO;
        public function __construct()
        {
            require_once("c://xampp/htdocs/control_finanzas/config/database.php");
            $con = new db();
            $this->PDO = $con->conexion();
        }

        public function getCuentas($usuario_id){
            $statement = $this->PDO->prepare("SELECT id, nombre, saldo FROM cuentas WHERE usuario_id = :id");
            $statement->bindParam(":id", $usuario_id);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }

        public function insertCuenta($usuario_id, $nombre, $saldo){

            $statement = $this->PDO->prepare(
                "INSERT INTO cuentas 
                (usuario_id, nombre, saldo)
                VALUES (:usuario_id, :nombre, :saldo)"
            );

            $statement->bindParam(":usuario_id", $usuario_id);
            $statement->bindParam(":nombre", $nombre);
            $statement->bindParam(":saldo", $saldo);

            return $statement->execute();
        }

        public function getCuenta($id, $usuario_id){

            $stament = $this->PDO->prepare(
                "SELECT * 
                FROM cuentas 
                WHERE id = :id 
                AND usuario_id = :usuario_id
                LIMIT 1"
            );

            $stament->bindParam(":id", $id);
            $stament->bindParam(":usuario_id", $usuario_id);
            $stament->execute();

            return $stament->fetch(PDO::FETCH_ASSOC);
        }

        public function updateCuenta($id, $nombre){

            $statement = $this->PDO->prepare(
                "UPDATE cuentas 
                SET nombre = :nombre
                WHERE id = :id"
            );

            $statement->bindParam(":nombre", $nombre);
            $statement->bindParam(":id", $id);

            return $statement->execute();
        }

        public function deleteCuenta($id){

            $statement = $this->PDO->prepare(
                "DELETE FROM cuentas WHERE id = :id"
            );

            $statement->bindParam(":id", $id);

            return $statement->execute();
        }

        public function cuentaEnUso($id, $usuario_id){

            $stament = $this->PDO->prepare(
                "SELECT COUNT(*) as total 
                FROM movimientos 
                WHERE cuenta_id = :id 
                AND usuario_id = :usuario_id"
            );

            $stament->bindParam(":id", $id);
            $stament->bindParam(":usuario_id", $usuario_id);
            $stament->execute();

            $resultado = $stament->fetch(PDO::FETCH_ASSOC);

            return $resultado["total"] > 0;
        }
    }
?>
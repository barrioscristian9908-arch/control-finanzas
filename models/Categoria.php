<?php
    class CategoriaModel{
        private $PDO;
        public function __construct()
        {
            require_once("c://xampp/htdocs/control_finanzas/config/database.php");
            $con = new db();
            $this->PDO = $con->conexion();
        }


        public function getCategorias($usuario_id){
            $statement = $this->PDO->prepare("SELECT id, nombre, tipo FROM categorias WHERE usuario_id = :id");
            $statement->bindParam(":id", $usuario_id);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }

        public function insertCategoria($usuario_id, $tipo, $nombre){

            $statement = $this->PDO->prepare(
                "INSERT INTO categorias 
                (usuario_id, tipo, nombre)
                VALUES (:usuario_id, :tipo, :nombre)"
            );

            $statement->bindParam(":usuario_id", $usuario_id);
            $statement->bindParam(":tipo", $tipo);
            $statement->bindParam(":nombre", $nombre);

            return $statement->execute();
        }

        public function categoriaEnUso($id, $usuario_id){

            $stament = $this->PDO->prepare(
                "SELECT COUNT(*) as total 
                FROM movimientos 
                WHERE categoria_id = :id 
                AND usuario_id = :usuario_id"
            );

            $stament->bindParam(":id", $id);
            $stament->bindParam(":usuario_id", $usuario_id);
            $stament->execute();

            $resultado = $stament->fetch(PDO::FETCH_ASSOC);

            return $resultado["total"] > 0;
        }

        public function deleteCategoria($id){
            $statement = $this->PDO->prepare("DELETE FROM categorias WHERE id = :id");
            $statement->bindParam(":id", $id);
            return $statement
            ->execute();
        }

        public function getCategoria($id){

            $stament = $this->PDO->prepare(
                "SELECT * FROM categorias WHERE id = :id LIMIT 1"
            );

            $stament->bindParam(":id", $id);
            $stament->execute();

            return $stament->fetch(PDO::FETCH_ASSOC);
        }

        public function updateCategoria($id, $tipo, $nombre){

            $statement = $this->PDO->prepare(
                "UPDATE categorias 
                SET tipo = :tipo,
                    nombre = :nombre
                WHERE id = :id"
            );

            $statement->bindParam(":tipo", $tipo);
            $statement->bindParam(":nombre", $nombre);
            $statement->bindParam(":id", $id);

            return $statement->execute();
        }

       
    }
?>
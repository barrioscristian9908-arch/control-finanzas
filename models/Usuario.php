<?php
    class AuthModel{
        private $PDO;
        public function __construct()
        {
            require_once("c://xampp/htdocs/control_finanzas/config/database.php");
            $con = new db();
            $this->PDO = $con->conexion();
        }

        public function login($user,$pass){
            $stament = $this->PDO->prepare("SELECT * FROM usuarios WHERE username = :username");
            $stament->bindParam(":username",$user);

            if($stament->execute()){
                $usuario = $stament->fetch(PDO::FETCH_ASSOC);

                if($usuario){
                    //Verificacion de la contraseña
                    if(password_verify($pass,$usuario["password"])){
                        session_start();
                        //Iniciando sesion y asignando el usuario
                        $_SESSION["usuario"] = $user;
                        $_SESSION["usuario_id"] = $usuario["id"];
                        return true;

                    }else{
                        //Contraseña incorrecta
                        return false;
                    }

                }else{
                    //No se encontraron resultados
                    return false;
                }

            }else{
                //Error en la consulta
                return false;
            }
        }

        public function logout(){
            session_start();

            //Limpia todas las sesiones
            $_SESSION = array();

            //Destruye las sesiones
            session_destroy();

            return true;
        }

        public function registrar($user, $passHash){

            $stament = $this->PDO->prepare(
                "INSERT INTO usuarios (username, password) VALUES (:user, :pass)"
            );

            $stament->bindParam(":user", $user);
            $stament->bindParam(":pass", $passHash);

            return ($stament->execute()) ? true : false;
        }

        public function getUsuarioPorUsername($user){

            $statement = $this->PDO->prepare(
                "SELECT id FROM usuarios WHERE username = :user LIMIT 1"
            );

            $statement->bindParam(":user", $user);
            $statement->execute();

            return $statement->fetch(PDO::FETCH_ASSOC);
        }
    }
?>
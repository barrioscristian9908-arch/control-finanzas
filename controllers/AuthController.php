<?php
class AuthController{
    private $model;

    public function __construct()
    {
        require_once("c://xampp/htdocs/control_finanzas/models/Usuario.php");
        $this->model = new AuthModel();
    }

    public function login($user, $pass){

        $datos = $this->model->login($user, $pass);

        if($datos != false){
            $_SESSION["mensaje"] = "Bienvenido";
            $_SESSION["tipo"] = "success";

            header("Location: /control_finanzas/index.php?action=panel");
            exit;
        }else{
            $_SESSION["mensaje"] = "Usuario o contraseña incorrectas";
            $_SESSION["tipo"] = "danger";

            header("Location: /control_finanzas/index.php?action=login");
            exit;
        }
    }

    public function logout(){
        $this->model->logout();

        session_start();

        $_SESSION["mensaje"] = "Sesión cerrada";
        $_SESSION["tipo"] = "success";

        if(!isset($_SESSION["usuario"])){
            header("Location: /control_finanzas/index.php?action=login");
            exit;
        }
    }

    public function isLogged(){
        if(session_status() == PHP_SESSION_NONE){
            session_start();
        }

        return isset($_SESSION["usuario"]);
    }

    public function registrar($user, $pass, $pass2){

        $errores = [];

        if(strlen($pass) < 8){
            $errores[] = "Debe tener al menos 8 caracteres";
        }

        if(!preg_match('/[A-Za-z]/', $pass)){
            $errores[] = "Debe contener al menos una letra";
        }

        if(!preg_match('/\d/', $pass)){
            $errores[] = "Debe contener al menos un número";
        }

        if($pass !== $pass2){
            $errores[] = "Las contraseñas no coinciden";
        }

        if(!empty($errores)){
            $_SESSION["mensaje"] = implode("<br>", $errores);
            $_SESSION["tipo"] = "danger";

            header("Location: /control_finanzas/index.php?action=register");
            exit;
        }

        // 🔹 validar usuario existente
        $usuarioExistente = $this->model->getUsuarioPorUsername($user);

        if($usuarioExistente){
            $_SESSION["mensaje"] = "El usuario ya está en uso";
            $_SESSION["tipo"] = "danger";

            header("Location: /control_finanzas/index.php?action=register");
            exit;
        }

        // 🔹 registrar
        $passHash = password_hash($pass, PASSWORD_DEFAULT);

        $registro = $this->model->registrar($user, $passHash);

        if($registro){
            $_SESSION["mensaje"] = "Registrado exitosamente";
            $_SESSION["tipo"] = "success";

            header("Location: /control_finanzas/index.php?action=login");
            exit;
        } else {
            $_SESSION["mensaje"] = "Error al registrar usuario";
            $_SESSION["tipo"] = "danger";

            header("Location: /control_finanzas/index.php?action=register");
            exit;
        }
    }
}
?>
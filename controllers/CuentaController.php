<?php

class CuentaController{
    private $model;

    public function __construct()
    {
        require_once("c://xampp/htdocs/control_finanzas/models/Cuenta.php");
        $this->model = new CuentaModel();    
    }

    public function index(){

        $usuario_id = $_SESSION["usuario_id"];

        $cuentas = $this->model->getCuentas($usuario_id);

        require_once("c://xampp/htdocs/control_finanzas/views/cuentas/index.php");
    }

    public function crear(){
        require_once("c://xampp/htdocs/control_finanzas/views/cuentas/crear.php");
    }

    public function store($data){

        $usuario_id = $_SESSION["usuario_id"];

        $nombre = $data["nombre"];
        $saldo = $data["saldo"];

        // guardar cuenta
        $this->model->insertCuenta($usuario_id, $nombre, $saldo);

        $_SESSION["mensaje"] = "Cuenta creada correctamente";
        $_SESSION["tipo"] = "success";

        header("Location: /control_finanzas/index.php?action=cuentas");
        exit;
    }

    public function editar($id){

        $usuario_id = $_SESSION["usuario_id"];

        $cuenta = $this->model->getCuenta($id, $usuario_id);

        if(!$cuenta){
            $_SESSION["mensaje"] = "Cuenta no encontrada o acceso denegado";
            $_SESSION["tipo"] = "danger";

            header("Location: /control_finanzas/index.php?action=cuentas");
            exit;
        }

        require_once("c://xampp/htdocs/control_finanzas/views/cuentas/editar.php");
    }

    public function update($data){

        $id = $data["id"];
        $nuevo_nombre = $data["nombre"];

        $cuenta = $this->model->getCuenta($id, $_SESSION["usuario_id"]);

        if(!$cuenta){
            $_SESSION["mensaje"] = "Cuenta no encontrada o acceso denegado";
            $_SESSION["tipo"] = "danger";

            // 🔥 volver al editar
            header("Location: /control_finanzas/index.php?action=cuentas.editar&id=".$id);
            exit;
        }

        // update
        $this->model->updateCuenta($id, $nuevo_nombre);

        $_SESSION["mensaje"] = "Cuenta actualizada correctamente";
        $_SESSION["tipo"] = "success";

        header("Location: /control_finanzas/index.php?action=cuentas");
        exit;
    }

    public function delete($id){

        $cuenta = $this->model->getCuenta($id, $_SESSION["usuario_id"]);

        if(!$cuenta){
            $_SESSION["mensaje"] = "Cuenta no existe o acceso denegado";
            $_SESSION["tipo"] = "danger";

            header("Location: /control_finanzas/index.php?action=cuentas");
            exit;
        }

        // 🚫 verificar uso
        if($this->model->cuentaEnUso($id, $_SESSION["usuario_id"])){
            $_SESSION["mensaje"] = "No podés eliminar esta cuenta porque tiene movimientos";
            $_SESSION["tipo"] = "danger";

            header("Location: /control_finanzas/index.php?action=cuentas");
            exit;
        }

        $this->model->deleteCuenta($id);

        $_SESSION["mensaje"] = "Cuenta eliminada";
        $_SESSION["tipo"] = "success";

        header("Location: /control_finanzas/index.php?action=cuentas");
        exit;
    }
}

?>
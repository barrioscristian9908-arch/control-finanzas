<?php

class MetaController{
    private $model;

    public function __construct()
    {
        require_once("c://xampp/htdocs/control_finanzas/models/Meta.php");
        $this->model = new MetaModel();    
    }

    public function index(){

        $usuario_id = $_SESSION["usuario_id"];

        $metas = $this->model->getMetas($usuario_id);

        require_once("c://xampp/htdocs/control_finanzas/views/metas/index.php");
    }

    public function crear(){
        require_once("c://xampp/htdocs/control_finanzas/views/metas/crear.php");
    }

    public function store($data){

        $usuario_id = $_SESSION["usuario_id"];

        $nombre = $data["nombre"];
        $monto_objetivo = $data["monto_objetivo"];
        $fecha_limite = $data["fecha_limite"] ?: null;

        $this->model->insertMeta($usuario_id, $nombre, $monto_objetivo, $fecha_limite);

        $_SESSION["mensaje"] = "Meta creada correctamente";
        $_SESSION["tipo"] = "success";

        // 🔥 antes iba al panel
        header("Location: /control_finanzas/index.php?action=metas");
        exit;
    }

    public function editar($id){

        $usuario_id = $_SESSION["usuario_id"];

        $meta = $this->model->getMeta($id, $usuario_id);

        if(!$meta){
            $_SESSION["mensaje"] = "Meta no encontrada o acceso denegado";
            $_SESSION["tipo"] = "danger";

            header("Location: /control_finanzas/index.php?action=metas");
            exit;
        }

        require_once("c://xampp/htdocs/control_finanzas/views/metas/editar.php");
    }

    public function update($data){

        $id = $data["id"];

        $nombre = $data["nombre"];
        $monto_objetivo = $data["monto_objetivo"];
        $fecha_limite = $data["fecha_limite"] ?: null;

        $usuario_id = $_SESSION["usuario_id"];

        $meta = $this->model->getMeta($id, $usuario_id);

        if(!$meta){
            $_SESSION["mensaje"] = "Meta no encontrada o acceso denegado";
            $_SESSION["tipo"] = "danger";

            // 🔥 volver al editar
            header("Location: /control_finanzas/index.php?action=metas.editar&id=".$id);
            exit;
        }

        // 🔥 obtener lo ahorrado
        $ahorrado = $this->model->getAhorroMeta($id, $usuario_id);

        // 🚫 VALIDACIÓN CLAVE
        if($monto_objetivo < $ahorrado){
            $_SESSION["mensaje"] = "El monto objetivo no puede ser menor a lo ya ahorrado ($$ahorrado)";
            $_SESSION["tipo"] = "danger";

            header("Location: /control_finanzas/index.php?action=metas.editar&id=".$id);
            exit;
        }

        $this->model->updateMeta($id, $nombre, $monto_objetivo, $fecha_limite);

        $_SESSION["mensaje"] = "Meta actualizada";
        $_SESSION["tipo"] = "success";

        header("Location: /control_finanzas/index.php?action=metas");
        exit;
    }

    public function delete($id){

        $usuario_id = $_SESSION["usuario_id"];

        $meta = $this->model->getMeta($id, $usuario_id);

        if(!$meta){
            $_SESSION["mensaje"] = "Meta no encontrada o acceso denegado";
            $_SESSION["tipo"] = "danger";

            header("Location: /control_finanzas/index.php?action=metas");
            exit;
        }

        // 🚫 verificar aportes
        if($this->model->metaEnUso($id, $usuario_id)){
            $_SESSION["mensaje"] = "No podés eliminar esta meta porque tiene aportes";
            $_SESSION["tipo"] = "danger";

            header("Location: /control_finanzas/index.php?action=metas");
            exit;
        }

        $this->model->deleteMeta($id);

        $_SESSION["mensaje"] = "Meta eliminada";
        $_SESSION["tipo"] = "success";

        header("Location: /control_finanzas/index.php?action=metas");
        exit;
    }

    public function aportar($id){

        $usuario_id = $_SESSION["usuario_id"];

        $meta = $this->model->getMeta($id, $usuario_id);

        if(!$meta){
            $_SESSION["mensaje"] = "Meta no encontrada o acceso denegado";
            $_SESSION["tipo"] = "danger";

            header("Location: /control_finanzas/index.php?action=metas");
            exit;
        }

        // 🔥 traer cuentas
        require_once("c://xampp/htdocs/control_finanzas/models/Movimiento.php");
        $movModel = new MovimientoModel();
        $cuentas = $movModel->getCuentas($usuario_id);

        require_once("c://xampp/htdocs/control_finanzas/views/metas/aportar.php");
    }

    public function storeAporte($data){

        $meta_id = $data["meta_id"];
        $monto = $data["monto"];
        $cuenta_id = $data["cuenta_id"];

        $usuario_id = $_SESSION["usuario_id"];

        $meta = $this->model->getMeta($meta_id, $usuario_id);

        if(!$meta){
            $_SESSION["mensaje"] = "Meta no encontrada o acceso denegado";
            $_SESSION["tipo"] = "danger";

            header("Location: /control_finanzas/index.php?action=metas");
            exit;
        }

        $ahorrado = $this->model->getAhorroMeta($meta_id, $usuario_id);

        if(($ahorrado + $monto) > $meta["monto_objetivo"]){
            $_SESSION["mensaje"] = "El aporte supera el objetivo de la meta";
            $_SESSION["tipo"] = "danger";

            header("Location: /control_finanzas/index.php?action=metas.aportar&id=".$meta_id);
            exit;
        }

        require_once("c://xampp/htdocs/control_finanzas/models/Movimiento.php");
        $movModel = new MovimientoModel();

        $tipo = "egreso";
        $descripcion = "Aporte a meta: " . $meta["nombre"];
        $categoria_id = null;

        // 🔥 1. crear movimiento y obtener ID
        $movimiento_id = $movModel->insertMovimiento(
            $usuario_id,
            $tipo,
            $monto,
            $cuenta_id,
            $categoria_id,
            $descripcion,
            $meta_id
        );

        // 🔥 2. guardar aporte con referencia al movimiento
        $this->model->insertAporte($meta_id, $monto, $movimiento_id);

        // 🔥 3. descontar saldo
        $movModel->restarSaldo($cuenta_id, $monto);

        $_SESSION["mensaje"] = "Aporte registrado correctamente";
        $_SESSION["tipo"] = "success";

        header("Location: /control_finanzas/index.php?action=metas");
        exit;
    }

    public function aportes($id){

        $usuario_id = $_SESSION["usuario_id"];

        $meta = $this->model->getMeta($id, $usuario_id);

        if(!$meta){
            $_SESSION["mensaje"] = "Meta no encontrada";
            $_SESSION["tipo"] = "danger";

            header("Location: /control_finanzas/index.php?action=metas");
            exit;
        }

        $aportes = $this->model->getAportes($id, $usuario_id);

        require_once("c://xampp/htdocs/control_finanzas/views/metas/aportes.php");
    }

    public function deleteAporte($id){

        $usuario_id = $_SESSION["usuario_id"];

        // 🔥 obtener aporte validado por usuario
        $aporte = $this->model->getAporte($id, $usuario_id);

        if(!$aporte){
            $_SESSION["mensaje"] = "Aporte no encontrado o acceso denegado";
            $_SESSION["tipo"] = "danger";

            header("Location: /control_finanzas/index.php?action=metas");
            exit;
        }

        require_once("c://xampp/htdocs/control_finanzas/models/Movimiento.php");
        $movModel = new MovimientoModel();

        // 🔥 traer movimiento vinculado
        $mov = $movModel->getMovimiento($aporte["movimiento_id"]);

        if($mov && $mov["usuario_id"] == $usuario_id){

            // 🔁 devolver saldo
            $movModel->sumarSaldo($mov["cuenta_id"], $mov["monto"]);

            // 🗑️ eliminar movimiento
            $movModel->deleteMovimiento($mov["id"]);
        }

        // 🗑️ eliminar aporte
        $this->model->deleteAporte($id);

        $_SESSION["mensaje"] = "Aporte eliminado correctamente";
        $_SESSION["tipo"] = "success";

        header("Location: /control_finanzas/index.php?action=metas");
        exit;
    }
 
}
?>
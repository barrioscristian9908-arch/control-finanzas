<?php

class MovimientoController{
    private $model;

    public function __construct()
    {
        require_once("c://xampp/htdocs/control_finanzas/models/Movimiento.php");
        $this->model = new MovimientoModel();    
    }

    // public function index(){

    //     $usuario_id = $_SESSION["usuario_id"];

    //     $movimientos = $this->model->getMovimientos($usuario_id);

    //     require_once("c://xampp/htdocs/control_finanzas/views/movimientos/index.php");
    // }

    public function index(){

        $usuario_id = $_SESSION["usuario_id"];

        // filtros
        $tipo = $_GET['tipo'] ?? null;
        $cuenta_id = $_GET['cuenta_id'] ?? null;
        $categoria_id = $_GET['categoria_id'] ?? null;
        $desde = $_GET['desde'] ?? null;
        $hasta = $_GET['hasta'] ?? null;

        // 👇 ahora usa filtrado
        $movimientos = $this->model->filtrar(
            $usuario_id,
            $tipo,
            $cuenta_id,
            $categoria_id,
            $desde,
            $hasta
        );

        // para los selects
        $cuentas = $this->model->getCuentas($usuario_id);
        $categorias = $this->model->getCategorias($usuario_id);

        require_once("c://xampp/htdocs/control_finanzas/views/movimientos/index.php");
    }

    public function crear(){

        $usuario_id = $_SESSION["usuario_id"];

        $cuentas = $this->model->getCuentas($usuario_id);
        $categorias = $this->model->getCategorias($usuario_id);

        require_once("c://xampp/htdocs/control_finanzas/views/movimientos/crear.php");
    }

    public function store($data){

        $usuario_id = $_SESSION["usuario_id"];

        $tipo = $data["tipo"];
        $monto = $data["monto"];
        $cuenta_id = $data["cuenta_id"];
        $categoria_id = $data["categoria_id"];
        $descripcion = $data["descripcion"] ?? null;

        // guardar movimiento
        $this->model->insertMovimiento($usuario_id, $tipo, $monto, $cuenta_id, $categoria_id, $descripcion);

        // actualizar saldo
        if($tipo == "ingreso"){
            $this->model->sumarSaldo($cuenta_id, $monto);
        }else{
            $this->model->restarSaldo($cuenta_id, $monto);
        }

        $_SESSION["mensaje"] = "Movimiento registrado correctamente";
        $_SESSION["tipo"] = "success";

        // 🔥 antes iba al panel
        header("Location: /control_finanzas/index.php?action=movimientos");
        exit;
    }

    public function delete($id){

        $mov = $this->model->getMovimiento($id);

        // 🔥 PROTECCIÓN
        if($mov["meta_id"] != null){
            $_SESSION["mensaje"] = "No podés eliminar un movimiento asociado a una meta";
            $_SESSION["tipo"] = "danger";

            header("Location: /control_finanzas/index.php?action=movimientos");
            exit;
        }

        // seguridad
        if($mov["usuario_id"] != $_SESSION["usuario_id"]){
            exit("Acceso denegado");
        }

        // revertir saldo
        if($mov["tipo"] == "ingreso"){
            $this->model->restarSaldo($mov["cuenta_id"], $mov["monto"]);
        }else{
            $this->model->sumarSaldo($mov["cuenta_id"], $mov["monto"]);
        }

        $this->model->deleteMovimiento($id);

        $_SESSION["mensaje"] = "Movimiento eliminado";
        $_SESSION["tipo"] = "success";

        header("Location: /control_finanzas/index.php?action=movimientos");
        exit;
    }

    public function editar($id){

        $usuario_id = $_SESSION["usuario_id"];

        $movimiento = $this->model->getMovimiento($id);

        // 🔐 validar existencia + usuario
        if(!$movimiento || $movimiento["usuario_id"] != $usuario_id){
            $_SESSION["mensaje"] = "Acceso denegado";
            $_SESSION["tipo"] = "danger";

            header("Location: /control_finanzas/index.php?action=movimientos");
            exit;
        }

        // 🚫 bloquear metas
        if(!empty($movimiento["meta_id"])){
            $_SESSION["mensaje"] = "No podés editar un movimiento vinculado a una meta";
            $_SESSION["tipo"] = "danger";

            header("Location: /control_finanzas/index.php?action=movimientos");
            exit;
        }

        $cuentas = $this->model->getCuentas($usuario_id);
        $categorias = $this->model->getCategorias($usuario_id);

        require_once("c://xampp/htdocs/control_finanzas/views/movimientos/editar.php");
    }

    public function update($data){

        $id = $data["id"];

        $nuevo_tipo = $data["tipo"];
        $nuevo_monto = $data["monto"];
        $cuenta_id = $data["cuenta_id"];
        $categoria_id = $data["categoria_id"];
        $descripcion = $data["descripcion"];

        // obtener viejo
        $mov = $this->model->getMovimiento($id);

        // 🔐 validar existencia + usuario
        if(!$mov || $mov["usuario_id"] != $_SESSION["usuario_id"]){
            $_SESSION["mensaje"] = "Acceso denegado";
            $_SESSION["tipo"] = "danger";

            header("Location: /control_finanzas/index.php?action=movimientos");
            exit;
        }

        // 🚫 bloquear metas
        if(!empty($mov["meta_id"])){
            $_SESSION["mensaje"] = "No podés editar un movimiento vinculado a una meta";
            $_SESSION["tipo"] = "danger";

            header("Location: /control_finanzas/index.php?action=movimientos");
            exit;
        }

        // 🔁 revertir viejo
        if($mov["tipo"] == "ingreso"){
            $this->model->restarSaldo($mov["cuenta_id"], $mov["monto"]);
        }else{
            $this->model->sumarSaldo($mov["cuenta_id"], $mov["monto"]);
        }

        // ➕ aplicar nuevo
        if($nuevo_tipo == "ingreso"){
            $this->model->sumarSaldo($cuenta_id, $nuevo_monto);
        }else{
            $this->model->restarSaldo($cuenta_id, $nuevo_monto);
        }

        // 💾 update
        $this->model->updateMovimiento($id, $nuevo_tipo, $nuevo_monto, $cuenta_id, $categoria_id, $descripcion);

        $_SESSION["mensaje"] = "Movimiento actualizado correctamente";
        $_SESSION["tipo"] = "success";

        header("Location: /control_finanzas/index.php?action=movimientos");
        exit;
    }


    // TRANFERIR
    public function transferir(){

        $usuario_id = $_SESSION["usuario_id"];

        // traer cuentas del usuario
        $cuentas = $this->model->getCuentas($usuario_id);

        require_once("c://xampp/htdocs/control_finanzas/views/movimientos/transferir.php");
    }

    public function storeTransferencia($data){

        $usuario_id = $_SESSION["usuario_id"];

        $cuenta_origen = $data["cuenta_origen"];
        $cuenta_destino = $data["cuenta_destino"];
        $monto = $data["monto"];

        // 🔴 VALIDACIONES (igual que antes)
        if($cuenta_origen == $cuenta_destino){
            $_SESSION["mensaje"] = "No podés transferir a la misma cuenta";
            $_SESSION["tipo"] = "danger";
            header("Location: /control_finanzas/index.php?action=movimientos.transferir");
            exit;
        }

        if($monto <= 0){
            $_SESSION["mensaje"] = "Monto inválido";
            $_SESSION["tipo"] = "danger";
            header("Location: /control_finanzas/index.php?action=movimientos.transferir");
            exit;
        }

        $cuentaOrigen = $this->model->getCuenta($cuenta_origen, $usuario_id);
        $cuentaDestino = $this->model->getCuenta($cuenta_destino, $usuario_id);

        if(!$cuentaOrigen || !$cuentaDestino){
            $_SESSION["mensaje"] = "Cuenta inválida";
            $_SESSION["tipo"] = "danger";
            header("Location: /control_finanzas/index.php?action=movimientos.transferir");
            exit;
        }

        if($cuentaOrigen["saldo"] < $monto){
            $_SESSION["mensaje"] = "Saldo insuficiente";
            $_SESSION["tipo"] = "danger";
            header("Location: /control_finanzas/index.php?action=movimientos.transferir");
            exit;
        }

        try {

            // 🔥 INICIAR TRANSACCIÓN
            $this->model->beginTransaction();

            // 🔹 egreso
            $this->model->insertMovimiento(
                $usuario_id,
                "egreso",
                $monto,
                $cuenta_origen,
                null,
                "Transferencia enviada"
            );

            // 🔹 ingreso
            $this->model->insertMovimiento(
                $usuario_id,
                "ingreso",
                $monto,
                $cuenta_destino,
                null,
                "Transferencia recibida"
            );

            // 🔹 actualizar saldos
            $this->model->restarSaldo($cuenta_origen, $monto);
            $this->model->sumarSaldo($cuenta_destino, $monto);

            // 🔥 CONFIRMAR
            $this->model->commit();

            $_SESSION["mensaje"] = "Transferencia realizada correctamente";
            $_SESSION["tipo"] = "success";

        } catch(Exception $e){

            // 🔥 SI ALGO FALLA → DESHACER TODO
            $this->model->rollBack();

            $_SESSION["mensaje"] = "Error en la transferencia";
            $_SESSION["tipo"] = "danger";
        }

        header("Location: /control_finanzas/index.php?action=movimientos");
        exit;
    }
}
?>
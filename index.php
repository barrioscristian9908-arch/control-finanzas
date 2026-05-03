<?php
session_start();

// Controllers
require_once("controllers/AuthController.php");
require_once("controllers/PanelController.php");
require_once("controllers/MovimientoController.php");
require_once("controllers/CategoriaController.php");
require_once("controllers/CuentaController.php");
require_once("controllers/MetaController.php");
require_once("controllers/ReporteController.php");

// Instancia auth
$auth = new AuthController();

// Acción actual
$action = $_GET["action"] ?? "login";

// 🔓 Rutas públicas
$publicRoutes = [
    "login",
    "register",
    "auth.login",
    "auth.register"
];

// 🔐 Protección de rutas
if(!in_array($action, $publicRoutes)){
    if(!$auth->isLogged()){
        header("Location: /control_finanzas/index.php?action=login");
        exit;
    }
}

// 🔁 Evitar volver a login si ya está logueado
if(in_array($action, ["login","register"]) && $auth->isLogged()){
    header("Location: /control_finanzas/index.php?action=panel");
    exit;
}

// 🚦 Router
switch($action){

    // 🔐 AUTH
    case "login":
        require_once("views/auth/login.php");
        break;

    case "register":
        require_once("views/auth/registro.php");
        break;

    case "auth.login":
        (new AuthController())->login($_POST["user"], $_POST["pass"]);
        break;

    case "auth.register":
        (new AuthController())->registrar($_POST["user"], $_POST["pass"], $_POST["pass2"]);
        break;

    case "logout":
        (new AuthController())->logout();
        break;

    // 📊 PANEL
    case "panel":
        (new PanelController())->index();
        break;

    // 💰 MOVIMIENTOS
    case "movimientos":
        (new MovimientoController())->index();
        break;

    case "movimientos.crear":
        (new MovimientoController())->crear();
        break;

    case "movimientos.store":
        (new MovimientoController())->store($_POST);
        break;

    case "movimientos.editar":
        (new MovimientoController())->editar($_GET["id"]);
        break;

    case "movimientos.update":
        (new MovimientoController())->update($_POST);
        break;

    case "movimientos.delete":
        (new MovimientoController())->delete($_GET["id"]);
        break;

    // 🏷️ CATEGORIAS
    case "categorias":
        (new CategoriaController())->index();
        break;

    case "categorias.crear":
        (new CategoriaController())->crear();
        break;

    case "categorias.store":
        (new CategoriaController())->store($_POST);
        break;

    case "categorias.editar":
        (new CategoriaController())->editar($_GET["id"]);
        break;

    case "categorias.update":
        (new CategoriaController())->update($_POST);
        break;
    
    case "categorias.delete":
        (new CategoriaController())->delete($_GET["id"]);
        break;

    // 💼 CUENTAS
    case "cuentas":
        (new CuentaController())->index();
        break;

    case "cuentas.crear":
        (new CuentaController())->crear();
        break;

    case "cuentas.store":
        (new CuentaController())->store($_POST);
        break;

    case "cuentas.editar":
        (new CuentaController())->editar($_GET["id"]);
        break;

    case "cuentas.update":
        (new CuentaController())->update($_POST);
        break;
    
    case "cuentas.delete":
        (new CuentaController())->delete($_GET["id"]);
        break;

    // 💼 METAS
    case "metas":
        (new MetaController())->index();
        break;

    case "metas.crear":
        (new MetaController())->crear();
        break;

    case "metas.store":
        (new MetaController())->store($_POST);
        break;
    
    case "metas.editar":
        (new MetaController())->editar($_GET["id"]);
        break;

    case "metas.update":
        (new MetaController())->update($_POST);
        break;
    
    case "metas.delete":
        (new MetaController())->delete($_GET["id"]);
        break;
    
    case "metas.aportar":
        (new MetaController())->aportar($_GET["id"]);
        break;
    
    case "metas.storeAporte":
        (new MetaController())->storeAporte($_POST);
        break;
    
    case "metas.aportes":
        (new MetaController())->aportes($_GET["id"]);
        break;

    case "metas.deleteAporte":
        (new MetaController())->deleteAporte($_GET["id"]);
        break;

    // 📊 REPORTES
    case "reportes":
        (new ReporteController())->index();
        break;

    // 🔄 TRANSFERIR
    case "movimientos.transferir":
        (new MovimientoController())->transferir();
        break;

    case "movimientos.storeTransferencia":
        (new MovimientoController())->storeTransferencia($_POST);
        break;

    // ❌ 404
    default:
        echo "404 - Página no encontrada";
        break;
}
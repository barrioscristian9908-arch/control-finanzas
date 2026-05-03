<?php

class ReporteController{
    private $model;

    public function __construct()
    {
        require_once("c://xampp/htdocs/control_finanzas/models/Movimiento.php");
        $this->model = new MovimientoModel();    
    }

    public function index(){

        $usuario_id = $_SESSION["usuario_id"];

        // 📅 fechas (con valores por defecto)
        $desde = $_GET["desde"] ?? date("Y-m-01");
        $hasta = $_GET["hasta"] ?? date("Y-m-d");

        // 📊 datos desde la BD
        $data = $this->model->getResumenPorFecha($usuario_id, $desde, $hasta);

        // 🔥 COMPLETAR DÍAS FALTANTES
        $fechas = [];

        $actual = strtotime($desde);
        $fin = strtotime($hasta);

        // 1. generar todos los días con 0
        while($actual <= $fin){

            $fecha = date("Y-m-d", $actual);

            $fechas[$fecha] = [
                "fecha" => $fecha,
                "ingresos" => 0,
                "egresos" => 0
            ];

            $actual = strtotime("+1 day", $actual);
        }

        // 2. reemplazar con datos reales
        foreach($data as $row){
            $fechas[$row["fecha"]] = $row;
        }

        // 3. reordenar array
        $data = array_values($fechas);

        // 🔥 OPCIONAL: mensaje si todo está en 0
        $hayDatos = false;
        foreach($data as $d){
            if($d["ingresos"] > 0 || $d["egresos"] > 0){
                $hayDatos = true;
                break;
            }
        }

        if(!$hayDatos){
            $_SESSION["mensaje"] = "No hay movimientos en ese rango de fechas";
            $_SESSION["tipo"] = "info";
        }

        $categorias = $this->model->getGastosPorCategoria($usuario_id, $desde, $hasta);

        require_once("c://xampp/htdocs/control_finanzas/views/reportes/index.php");
    }
}
?>
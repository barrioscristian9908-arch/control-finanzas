<?php

class PanelController{
    private $model;

    public function __construct()
    {
        require_once("c://xampp/htdocs/control_finanzas/models/Panel.php");
        $this->model = new PanelModel();    
    }

    public function index(){

        $usuario_id = $_SESSION["usuario_id"];

        $balance = $this->model->getBalance($usuario_id);
        $ingresos = $this->model->getIngresos($usuario_id);
        $egresos = $this->model->getEgresos($usuario_id);
        $totalCuentas = $this->model->getTotalCuentas($usuario_id);
        $movimientos = $this->model->getMovimientos($usuario_id);
        $metas = $this->model->getMetas($usuario_id);

        require_once("c://xampp/htdocs/control_finanzas/views/panel.php");
    }
}
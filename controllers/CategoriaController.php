<?php

class CategoriaController{
    private $model;

    public function __construct()
    {
        require_once("c://xampp/htdocs/control_finanzas/models/Categoria.php");
        $this->model = new CategoriaModel();    
    }

    public function index(){

        $usuario_id = $_SESSION["usuario_id"];

        $categorias = $this->model->getCategorias($usuario_id);

        require_once("c://xampp/htdocs/control_finanzas/views/categorias/index.php");
    }

    public function crear(){
        require_once("c://xampp/htdocs/control_finanzas/views/categorias/crear.php");
    }

    public function store($data){

        $usuario_id = $_SESSION["usuario_id"];

        $tipo = $data["tipo"];
        $nombre = $data["nombre"];

        // guardar categoria
        $this->model->insertCategoria($usuario_id, $tipo, $nombre);

        $_SESSION["mensaje"] = "Categoría creada correctamente";
        $_SESSION["tipo"] = "success";

        // 🔥 antes iba al panel (mal)
        header("Location: /control_finanzas/index.php?action=categorias");
        exit;
    }

    public function delete($id){

        $categoria = $this->model->getCategoria($id);

        if(!$categoria){
            $_SESSION["mensaje"] = "Categoría no existe";
            $_SESSION["tipo"] = "danger";

            header("Location: /control_finanzas/index.php?action=categorias");
            exit;
        }

        if($categoria["usuario_id"] != $_SESSION["usuario_id"]){
            $_SESSION["mensaje"] = "Acceso denegado";
            $_SESSION["tipo"] = "danger";

            header("Location: /control_finanzas/index.php?action=categorias");
            exit;
        }

        // 🚫 verificar uso
        if($this->model->categoriaEnUso($id, $_SESSION["usuario_id"])){
            $_SESSION["mensaje"] = "No podés eliminar esta categoría porque está en uso";
            $_SESSION["tipo"] = "danger";

            header("Location: /control_finanzas/index.php?action=categorias");
            exit;
        }

        $this->model->deleteCategoria($id);

        $_SESSION["mensaje"] = "Categoría eliminada";
        $_SESSION["tipo"] = "success";

        header("Location: /control_finanzas/index.php?action=categorias");
        exit;
    }

    public function editar($id){

        $usuario_id = $_SESSION["usuario_id"];

        $categoria = $this->model->getCategoria($id);

        if(!$categoria || $categoria["usuario_id"] != $usuario_id){
            $_SESSION["mensaje"] = "Categoría no encontrada o acceso denegado";
            $_SESSION["tipo"] = "danger";

            header("Location: /control_finanzas/index.php?action=categorias");
            exit;
        }

        require_once("c://xampp/htdocs/control_finanzas/views/categorias/editar.php");
    }

    public function update($data){

        $id = $data["id"];

        $nuevo_tipo = $data["tipo"];
        $nuevo_nombre = $data["nombre"];

        // obtener actual
        $cat = $this->model->getCategoria($id);

        // seguridad 🔥
        if(!$cat || $cat["usuario_id"] != $_SESSION["usuario_id"]){
            $_SESSION["mensaje"] = "Acceso denegado";
            $_SESSION["tipo"] = "danger";

            // 🔥 volver al editar
            header("Location: /control_finanzas/index.php?action=categorias.editar&id=".$id);
            exit;
        }

        // 🚫 evitar cambiar tipo si está en uso
        if($cat["tipo"] != $nuevo_tipo){
            if($this->model->categoriaEnUso($id, $_SESSION["usuario_id"])){
                $_SESSION["mensaje"] = "No podés cambiar el tipo de una categoría en uso";
                $_SESSION["tipo"] = "danger";

                // 🔥 volver al editar
                header("Location: /control_finanzas/index.php?action=categorias.editar&id=".$id);
                exit;
            }
        }

        // update
        $this->model->updateCategoria($id, $nuevo_tipo, $nuevo_nombre);

        $_SESSION["mensaje"] = "Categoría actualizada correctamente";
        $_SESSION["tipo"] = "success";

        header("Location: /control_finanzas/index.php?action=categorias");
        exit;
    }
 
}
?>
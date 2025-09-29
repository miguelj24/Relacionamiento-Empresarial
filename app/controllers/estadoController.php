<?php
namespace App\Controllers;
use App\Models\EstadoModel;

require_once "baseController.php";
require_once MAIN_APP_ROUTE."../models/EstadoModel.php";

class EstadoController extends BaseController {
    public function __construct() {
        // Se define la plantilla para este controlador
        $this->layout = "admin_layout";
        // Llamamos al constructor del padre
        parent::__construct();
    }

    public function index() {
        echo "<br>CONTROLLER> estadoController";
        echo "<br>ACTION> index";
    }

    public function view() {
        $estadoObj = new EstadoModel();
        $estados = $estadoObj->getAll();
        $data = [
            "estados" => $estados,
            "titulo" => "Lista de estados"
        ];
        $this->render('estado/view.php', $data);
    }

    public function newEstado() {
        $data = [
            "titulo" => "Nuevo estado"
        ];
        $this->render('estado/new.php', $data);
    }

    public function createEstado() {
        if (isset($_POST["Estado"])) {
            $estado = $_POST["Estado"] ?? null;
            $descripcion = $_POST["Descripcion"] ?? null;
            
            $estadoObj = new EstadoModel();
            $estadoObj->saveEstado($estado, $descripcion);
            $this->redirectTo("estado/view");
        }
    }

    public function viewEstado($id) {
        $estadoObj = new EstadoModel();
        $estadoInfo = $estadoObj->getEstado($id);
        $data = [
            "estado" => $estadoInfo,
            "titulo" => "Ver estado: " . $estadoInfo->Estado
        ];
        $this->render("estado/viewOne.php", $data);
    }

    public function editEstado($id) {
        $estadoObj = new EstadoModel();
        $estadoInfo = $estadoObj->getEstado($id);
        $data = [
            "estado" => $estadoInfo,
            "titulo" => "Editar estado"
        ];
        $this->render("estado/edit.php", $data);
    }

    public function updateEstado() {
        if (isset($_POST["Estado"])) {
            $id = $_POST["idEstado"] ?? null;
            $estado = $_POST["Estado"] ?? null;
            $descripcion = $_POST["Descripcion"] ?? null;
            $color = $_POST["Color"] ?? '#4361ee'; // Nuevo: obtener color

            $estadoObj = new EstadoModel();
            $estadoObj->editEstado($id, $estado, $descripcion, $color); // Pasar color
        }
        $this->redirectTo("estado/view");
    }

    public function deleteEstado($id) {
        $estadoObj = new EstadoModel();
        $estadoObj->deleteEstado($id);
        $this->redirectTo("estado/view");
    }
}

<?php
namespace App\Controllers;
use App\Models\ServicioModel;

require_once "baseController.php";
require_once MAIN_APP_ROUTE."../models/ServicioModel.php";

class ServicioController extends BaseController {
    public function __construct(){
        $this->layout = "admin_layout";
        parent::__construct();
    }

    public function view(){
        $servicioObj = new ServicioModel();
        $servicios = $servicioObj->getAll();
        $data = [
            "titulo" => "Lista de Servicios",
            "servicios" => $servicios
        ];
        $this->render('servicio/view.php', $data);
    }

    public function newServicio(){
        $data = [
            "titulo" => "Nuevo Servicio"
        ];
        $this->render('servicio/new.php', $data);
    }

    public function createServicio(){
        if (isset($_POST["Servicio"]) && isset($_POST["Color"])) {
            $servicio = $_POST["Servicio"];
            $color = $_POST["Color"];
            $servicioObj = new ServicioModel();
            $servicioObj->saveServicio($servicio, $color);
            $this->redirectTo("servicio/view");
        }
    }

    public function viewServicio($id){
        $servicioObj = new ServicioModel();
        $servicioInfo = $servicioObj->getServicio($id);
        $data = [
            "servicio" => $servicioInfo,
            "titulo" => "Ver Servicio: ".$servicioInfo->service
        ];
        $this->render("servicio/viewOne.php", $data);
    }

    public function editServicio($id){
        $servicioObj = new ServicioModel();
        $servicioInfo = $servicioObj->getServicio($id);
        $data = [
            "servicio" => $servicioInfo,
            "titulo" => "Editar Servicio"
        ];
        $this->render("servicio/edit.php", $data);
    }

    public function updateServicio(){
        if (isset($_POST["Servicio"]) && isset($_POST["Color"])) {
            $id = $_POST["idServicio"];
            $servicio = $_POST["Servicio"];
            $color = $_POST["Color"];
            
            $servicioObj = new ServicioModel();
            $servicioObj->editServicio($id, $servicio, $color);
            $this->redirectTo("servicio/view");
        }
    }

    public function deleteServicio($id){
        $servicioObj = new ServicioModel();
        $servicioObj->deleteServicio($id);
        $this->redirectTo("servicio/view");
    }
}
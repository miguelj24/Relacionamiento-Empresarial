<?php
namespace App\Controllers;
use App\Models\TipoServicioModel;
use App\Models\ServicioModel;

require_once "baseController.php";
require_once MAIN_APP_ROUTE."../models/tipoServicioModel.php";
require_once MAIN_APP_ROUTE."../models/ServicioModel.php";

class TipoServicioController extends BaseController {
    public function __construct(){
        $this->layout = "admin_layout";
        parent::__construct();
    }

    public function view(){
        $tipoServicioObj = new TipoServicioModel();
        $tiposServicio = $tipoServicioObj->getAll();
        $data = [
            "titulo" => "Lista de Tipos de Servicio",
            "tiposServicio" => $tiposServicio
        ];
        $this->render('tipoServicio/view.php', $data);
    }

    public function newTipoServicio(){
        $servicioObj = new ServicioModel();
        $servicios = $servicioObj->getAll();
        $data = [
            "titulo" => "Nuevo Tipo de Servicio",
            "servicios" => $servicios
        ];
        $this->render('tipoServicio/new.php', $data);
    }

    public function createTipoServicio(){
        if (isset($_POST["TipoServicio"]) && isset($_POST["FKidServicio"])) {
            $tipoServicio = $_POST["TipoServicio"];
            $FKidServicio = $_POST["FKidServicio"];
            
            $tipoServicioObj = new TipoServicioModel();
            $tipoServicioObj->saveTipoServicio($tipoServicio, $FKidServicio);
            $this->redirectTo("tipoServicio/view");
        }
    }

    public function viewTipoServicio($id){
        $tipoServicioObj = new TipoServicioModel();
        $tipoServicioInfo = $tipoServicioObj->getTipoServicio($id);
        $data = [
            "tipoServicio" => $tipoServicioInfo,
            "titulo" => "Ver Tipo de Servicio: ".$tipoServicioInfo->serviceType
        ];
        $this->render("tipoServicio/viewOne.php", $data);
    }

    public function editTipoServicio($id){
        $tipoServicioObj = new TipoServicioModel();
        $servicioObj = new ServicioModel();
        
        $tipoServicioInfo = $tipoServicioObj->getTipoServicio($id);
        $servicios = $servicioObj->getAll();
        
        $data = [
            "tipoServicio" => $tipoServicioInfo,
            "servicios" => $servicios,
            "titulo" => "Editar Tipo de Servicio"
        ];
        $this->render("tipoServicio/edit.php", $data);
    }

    public function updateTipoServicio(){
        if (isset($_POST["TipoServicio"]) && isset($_POST["FKidServicio"])) {
            $id = $_POST["idTipoServicio"];
            $tipoServicio = $_POST["TipoServicio"];
            $FKidServicio = $_POST["FKidServicio"];
            
            $tipoServicioObj = new TipoServicioModel();
            $tipoServicioObj->editTipoServicio($id, $tipoServicio, $FKidServicio);
        }
        $this->redirectTo("tipoServicio/view");
    }

    public function deleteTipoServicio($id){
        $tipoServicioObj = new TipoServicioModel();
        $tipoServicioObj->deleteTipoServicio($id);
        $this->redirectTo("tipoServicio/view");
    }

    public function getTiposServicioByServicio($idServicio) {
        $tipoServicioObj = new TipoServicioModel();
        $tiposServicio = $tipoServicioObj->getByServicio($idServicio);

        // Devolver los datos como JSON
        header('Content-Type: application/json');
        echo json_encode($tiposServicio);
    }
}
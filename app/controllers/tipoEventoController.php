<?php
namespace App\Controllers;
use App\Models\TipoEventoModel;

require_once "baseController.php";
require_once MAIN_APP_ROUTE."../models/TipoEventoModel.php";

class TipoEventoController extends BaseController {
    public function __construct(){
        $this->layout = "admin_layout";
        parent::__construct();
    }

    public function view(){
        $tipoEventoObj = new TipoEventoModel();
        $tiposEvento = $tipoEventoObj->getAll();
        $data = [
            "titulo" => "Lista de Tipos de Evento",
            "tiposEvento" => $tiposEvento
        ];
        $this->render('tipoEvento/view.php', $data);
    }

    public function newTipoEvento(){
        $data = [
            "titulo" => "Nuevo Tipo de Evento"
        ];
        $this->render('tipoEvento/new.php', $data);
    }

    public function createTipoEvento(){
        if (isset($_POST["TipoEvento"])) {
            $tipoEvento = $_POST["TipoEvento"];
            $tipoEventoObj = new TipoEventoModel();
            $tipoEventoObj->saveTipoEvento($tipoEvento);
            $this->redirectTo("tipoEvento/view");
        }
    }

    public function viewTipoEvento($id){
        $tipoEventoObj = new TipoEventoModel();
        $tipoEventoInfo = $tipoEventoObj->getTipoEvento($id);
        $data = [
            "tipoEvento" => $tipoEventoInfo,
            "titulo" => "Ver Tipo de Evento: ".$tipoEventoInfo->TipoEvento
        ];
        $this->render("tipoEvento/viewOne.php", $data);
    }

    public function editTipoEvento($id){
        $tipoEventoObj = new TipoEventoModel();
        $tipoEventoInfo = $tipoEventoObj->getTipoEvento($id);
        $data = [
            "tipoEvento" => $tipoEventoInfo,
            "titulo" => "Editar Tipo de Evento"
        ];
        $this->render("tipoEvento/edit.php", $data);
    }

    public function updateTipoEvento(){
        if (isset($_POST["TipoEvento"])) {
            $id = $_POST["idTipoEvento"];
            $tipoEvento = $_POST["TipoEvento"];
            
            $tipoEventoObj = new TipoEventoModel();
            $tipoEventoObj->editTipoEvento($id, $tipoEvento);
            $this->redirectTo("tipoEvento/view");
        }
    }

    public function deleteTipoEvento($id){
        $tipoEventoObj = new TipoEventoModel();
        $tipoEventoObj->deleteTipoEvento($id);
        $this->redirectTo("tipoEvento/view");
    }
}
<?php
namespace App\Controllers;
use App\Models\RolModel;

require_once "baseController.php";
require_once MAIN_APP_ROUTE."../models/RolModel.php";

class RolController extends BaseController{
    public function __construct(){
        $this->layout = "admin_layout";
        parent::__construct();
    }
    
    public function view(){
        $rolObj = new RolModel();
        $roles = $rolObj->getAll();
        $data = [
            "roles" => $roles,
            "titulo" => "Lista de Roles"
        ];
        $this->render('rol/view.php', $data);
    }

    public function newRol(){
        $data = [
            "titulo" => "Nuevo Rol"
        ];
        $this->render('rol/new.php', $data);
    }

    public function createRol(){
        if (isset($_POST["Rol"])) {
            $rol = $_POST["Rol"] ?? null;
            $rolObj = new RolModel();
            $rolObj->saveRol($rol);
            $this->redirectTo("rol/view");
        }
    }

    public function viewRol($id){
        $rolObj = new RolModel();
        $rolInfo = $rolObj->getRol($id);
        $data = [
            "rol" => $rolInfo,
            "titulo" => "Ver Rol: ".$rolInfo->Role
        ];
        $this->render("rol/viewOne.php", $data);
    }
    
    public function editRol($id){
        $rolObj = new RolModel();
        $rolInfo = $rolObj->getRol($id);
        $data = [
            "rol" => $rolInfo,
            "titulo" => "Editar Rol"
        ];
        $this->render("rol/edit.php", $data);
    }
    
    public function updateRol(){
        if (isset($_POST["Rol"])) {
            $id = $_POST["idRol"] ?? null;
            $rol = $_POST["Rol"] ?? null;
            
            $rolObj = new RolModel();
            $rolObj->editRol($id, $rol);
        }
        $this->redirectTo("rol/view");
    }

    public function deleteRol($id){
        $rolObj = new RolModel();
        $rolObj->deleteRol($id);
        $this->redirectTo("rol/view");
    }

    public function saveDataFlutter(){
        // Establecer la cabecera Content-Type
        header('Content-Type: application/json');
        $resp = [
            "message" => "Datos registrados correctamente",
            "status" => true
        ];

        $respJson = json_encode($resp);
        echo $respJson;

    }
}
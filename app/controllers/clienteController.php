<?php
namespace App\Controllers;
use App\Models\ClienteModel;

require_once "baseController.php";
require_once MAIN_APP_ROUTE."../models/ClienteModel.php";

class ClienteController extends BaseController{
    public function __construct(){
        //Se define la plantilla para este controlador
        $this->layout = "admin_layout";
        //Llamamos al contructor del padre
        parent::__construct();
        
    }
    
    public function index(){
        echo "<br>CONTROLLER> clienteController";
        echo "<br>ACTION> index";
    }
    
    public function view(){
        $clienteObj = new ClienteModel();
        $clientes = $clienteObj->getAll();
        $data = [
            "clientes" => $clientes,
            "titulo" => "Lista de clientes"
        ];
        $this->render('cliente/view.php', $data);
    }

    public function newCliente(){
        $data = [
            "titulo" => "Nuevo cliente"
        ];
        $this->render('cliente/new.php', $data);
    }

    public function createCliente(){
        if (isset($_POST["DocumentoCliente"])) {
            $documentoCliente = $_POST["DocumentoCliente"] ?? null;
            $nombreCliente = $_POST["NombreCliente"] ?? null;
            $correoCliente = $_POST["CorreoCliente"] ?? null;
            $telefonoCliente = $_POST["TelefonoCliente"] ?? null;
            
            $clienteObj = new ClienteModel();
            $clienteObj->saveCliente($documentoCliente, $nombreCliente, $correoCliente, $telefonoCliente);
            $this->redirectTo("cliente/view");
        }
    }

    public function viewCliente($id){
        $clienteObj = new ClienteModel();
        $clienteInfo = $clienteObj->getCliente($id);
        $data = [
            "cliente" => $clienteInfo,
            "titulo" => "Ver cliente: ".$clienteInfo->NombreCliente
        ];

        // Detectar si es una petición AJAX
        if (
            !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
        ) {
            // Renderiza solo el fragmento, sin layout
            $this->renderPartial("cliente/viewOne.php", $data);
        } else {
            // Renderiza con layout normalmente
            $this->render("cliente/viewOne.php", $data);
        }
    }

    public function editCliente($id){
        $clienteObj = new ClienteModel();
        $clienteInfo = $clienteObj->getCliente($id);
        $data = [
            "cliente" => $clienteInfo,
            "titulo" => "Editar cliente"
        ];
        $this->render("cliente/edit.php", $data);
    }

    public function updateCliente(){
        if (isset($_POST["DocumentoCliente"])) {
            $id = $_POST["idCliente"] ?? null;
            $documentoCliente = $_POST["DocumentoCliente"] ?? null;
            $nombreCliente = $_POST["NombreCliente"] ?? null;
            $correoCliente = $_POST["CorreoCliente"] ?? null;
            $telefonoCliente = $_POST["TelefonoCliente"] ?? null;
            
            $clienteObj = new ClienteModel();
            $clienteObj->editCliente($id, $documentoCliente, $nombreCliente, $correoCliente, $telefonoCliente);
        }
        $this->redirectTo("cliente/view");
    }

    public function deleteCliente($id){
        $clienteObj = new ClienteModel();
        $clienteObj->deleteCliente($id);
        $this->redirectTo("cliente/view");
    }
}
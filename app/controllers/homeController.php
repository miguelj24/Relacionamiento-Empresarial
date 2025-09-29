<?php
namespace App\Controllers;
use App\Controllers\BaseController;
require_once "baseController.php";

class HomeController extends BaseController
{
    public function index(){
        $this->redirectTo("login/init");
        // $this -> render(); // se llama el metodo del papá
    }
    public function saludar(){
        echo "<br>CONTROLLER> HomeController";
        echo "<br>ACTION> saludos!";
    }
}
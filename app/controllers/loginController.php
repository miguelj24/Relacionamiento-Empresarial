<?php

namespace App\Controllers;

use App\models\UsuarioModel;

require_once "baseController.php";
require_once MAIN_APP_ROUTE . "../models/UsuarioModel.php";

class LoginController extends BaseController
{
    public function __construct()
    {
        $this->layout = "login_layout";
    }

    public function initLogin()
    {
        if (isset($_POST["txtUser"]) && isset($_POST["txtPassword"])) {
            $user = trim($_POST["txtUser"]) ?? null;
            $password = trim($_POST["txtPassword"]) ?? null;

            if ($user != null && $password != null) {
                //se valida la existencia del usuario y contraseña en la BD
                $loginObj = new UsuarioModel();
                $resp = $loginObj->validarLogin($user, $password);
                if ($resp) {
                    $userRole = $_SESSION['rol'];

                    // Role-based redirection
                    switch ($userRole) {
                        case 1: //Administrador
                            $this->redirectTo("usuario/indexAdministrador");
                            break;
                        case 2: //Administrativo
                            $this->redirectTo("usuario/indexAdministrativo");
                            break;
                        case 3: //Funcionario
                            $this->redirectTo("usuario/indexBienvenida");
                            break;
                        default: //Instructor
                            $this->redirectTo("usuario/indexBienvenida");
                    }
                    exit();
                } else {
                    $errors = "El usuario y/o contraseña son incorrectos";
                }
            } else {
                $errors = "El usuario y/o contraseña no pueden ser vacíos";
            }
            $data = [
                "errors" => $errors,
            ];
            $this->render("login/login.php", $data);
        } else {
            //Se renderiza el formulario del login
            $this->render("login/login.php");
        }
    }

    public function logoutLogin()
    {
        session_destroy();
        header("Location: /login/init");
    }

    // Mantener sesión activa
    public function keepAlive()
    {
        // Asegurar que la sesión esté iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Verificar si hay una sesión activa
        if (isset($_SESSION['usuario_id'])) {
            $_SESSION['timeOut'] = time();
            
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true, 
                'message' => 'Sesión renovada',
                'timestamp' => time()
            ]);
        } else {
            header('Content-Type: application/json');
            http_response_code(401);
            echo json_encode([
                'success' => false, 
                'message' => 'Sesión no válida'
            ]);
        }
        exit();
    }

    // Verificar estado de sesión
    public function status()
    {
        // Asegurar que la sesión esté iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $timeout = 15 * 60; // 15 minutos (igual que en baseController)
        
        $active = isset($_SESSION['timeOut']) && 
                  isset($_SESSION['usuario_id']) && 
                  (time() - $_SESSION['timeOut']) < $timeout;

        header('Content-Type: application/json');
        echo json_encode([
            'active' => $active,
            'remaining_time' => $active ? ($timeout - (time() - $_SESSION['timeOut'])) : 0,
            'timestamp' => time()
        ]);
        exit();
    }
}
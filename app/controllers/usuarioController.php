<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\RolModel;
use PDO;

require_once "baseController.php";
require_once MAIN_APP_ROUTE . "../models/UsuarioModel.php";
require_once MAIN_APP_ROUTE . "../models/RolModel.php";
require_once MAIN_APP_ROUTE . "../models/SolicitudModel.php";

class UsuarioController extends BaseController
{
    public function __construct()
    {
        $this->layout = "admin_layout";
        parent::__construct();
    }

    public function bienvenida()
    {
        $this->render('usuario/indexBienvenida.php', ["titulo" => "Home"]);
    }

    public function HomeAdmin()
    {
        $this->render('usuario/indexAdministrador.php', ["titulo" => "Home Admin"]);
    }

    // Versión unificada: incluye usuarios + solicitudes + movimientos
    public function Estadisticas()
    {
        $usuarioObj = new UsuarioModel();
        $totalUsuarios = $usuarioObj->countUsuarios(); // total de usuarios

        $solicitudObj = new \App\Models\SolicitudModel();
        $totalSolicitudesPendientes = $solicitudObj->getSolicitudesPendientes();
        $totalSolicitudesResueltas = $solicitudObj->getSolicitudesResueltas();
        $totalSolicitudesEnProceso = $solicitudObj->getSolicitudesEnProceso();

        // Últimos movimientos
        $ultimosMovimientos = $solicitudObj->getUltimosMovimientos();

        $this->render('usuario/indexAdministrativo.php', [
            "titulo" => "Estadísticas",
            "totalUsuarios" => $totalUsuarios,
            "totalSolicitudesPendientes" => $totalSolicitudesPendientes,
            "totalSolicitudesResueltas" => $totalSolicitudesResueltas,
            "totalSolicitudesEnProceso" => $totalSolicitudesEnProceso,
            "ultimosMovimientos" => $ultimosMovimientos
        ]);
    }

    public function view()
    {
        $usuarioObj = new UsuarioModel();
        $usuarios = $usuarioObj->getAll();
        $data = [
            "titulo" => "Lista de Usuarios",
            "usuarios" => $usuarios
        ];
        $this->render('usuario/view.php', $data);
    }

    public function newUsuario()
    {
        $rolObj = new RolModel();
        $roles = $rolObj->getAll();
        $data = [
            "titulo" => "Nuevo Usuario",
            "roles" => $roles
        ];
        $this->render('usuario/new.php', $data);
    }

    public function createUsuario()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuarioObj = new UsuarioModel();
            
            // Convertir el valor del select a booleano
            $coordinador = isset($_POST['Coordinador']) && $_POST['Coordinador'] == '1';
            
            $resultado = $usuarioObj->saveUsuario(
                $_POST['DocumentoUsuario'],
                $_POST['NombreUsuario'],
                $_POST['CorreoUsuario'],
                $_POST['TelefonoUsuario'],
                $_POST['ContraseñaUsuario'],
                $_POST['FKidRol'],
                $coordinador
            );
            
            if ($resultado) {
                $this->redirectTo("usuario/view");
            }
        }
    }

    public function viewUsuario($id)
    {
        $usuarioObj = new UsuarioModel();
        $usuario = $usuarioObj->getUsuario($id);
        $data = [
            "titulo" => "Ver Usuario",
            "usuario" => $usuario
        ];

        if (
            !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
        ) {
            $this->renderPartial("usuario/viewOne.php", $data);
        } else {
            $this->render("usuario/viewOne.php", $data);
        }
    }

    public function editUsuario($id)
    {
        $usuarioObj = new UsuarioModel();
        $rolObj = new RolModel();

        $usuario = $usuarioObj->getUsuario($id);
        $roles = $rolObj->getAll();

        $data = [
            "titulo" => "Editar Usuario",
            "usuario" => $usuario,
            "roles" => $roles
        ];

        $this->render("usuario/edit.php", $data);
    }

    public function updateUsuario()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuarioObj = new UsuarioModel();
            
            $nuevaContrasena = !empty($_POST['ContrasenaUsuario']) ? $_POST['ContrasenaUsuario'] : null;
            $coordinador = isset($_POST['Coordinador']) && $_POST['Coordinador'] == '1';
            
            $resultado = $usuarioObj->editUsuario(
                $_POST['idUsuario'],
                $_POST['DocumentoUsuario'],
                $_POST['NombreUsuario'],
                $_POST['CorreoUsuario'],
                $_POST['TelefonoUsuario'],
                $nuevaContrasena,
                $_POST['FKidRol'],
                $coordinador
            );
            
            if ($resultado) {
                $_SESSION['mensaje'] = 'Usuario actualizado correctamente';
            } else {
                $_SESSION['error'] = 'Error al actualizar usuario';
            }
            
            $this->redirectTo("usuario/perfil");
        }
    }

    public function deleteUsuario($id)
    {
        $usuarioObj = new UsuarioModel();
        $usuarioObj->deleteUsuario($id);
        $this->redirectTo("usuario/view");
    }

    public function perfil()
    {
        $idUsuario = $_SESSION["idUsuario"];

        $usuarioObj = new UsuarioModel();
        $usuario = $usuarioObj->getUsuario($idUsuario);

        $data = [
            "titulo" => "Perfil Usuario",
            "usuario" => $usuario
        ];

        $this->render('usuario/usuarioPerfil.php', $data);
    }
}

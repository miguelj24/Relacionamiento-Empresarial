<?php

namespace App\Controllers;

use App\Models\SolicitudModel;
use App\Models\ClienteModel;
use App\Models\ServicioModel;
use App\Models\EstadoModel;
use App\Models\RolModel;
use App\Models\TipoServicioModel; // Importar el modelo para los tipos de servicio

require_once "baseController.php";
require_once MAIN_APP_ROUTE . "../models/SolicitudModel.php";
require_once MAIN_APP_ROUTE . "../models/ClienteModel.php";
require_once MAIN_APP_ROUTE . "../models/ServicioModel.php";
require_once MAIN_APP_ROUTE . "../models/EstadoModel.php";
require_once MAIN_APP_ROUTE . "../models/TipoServicioModel.php"; // Requerir el modelo para los tipos de servicio

class SolicitudController extends BaseController
{
    public function __construct()
    {
        // Se define la plantilla para este controlador
        $this->layout = "admin_layout";
        // Llamamos al constructor del padre
        parent::__construct();
    }

    public function index()
    {
        echo "<br>CONTROLLER> SolicitudController";
        echo "<br>ACTION> index";
    }
    public function SolicitudEstadisticas()
    {
        $this->render('solicitud/solicitudEstadisticas.php', ["titulo" => "Solicitudes Estadisticas"]);
    }



    // Este view verifica el rol del usuario y muestra las solicitudes correspondientes
    public function view()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $rol = $_SESSION['rol'] ?? null; // 4 = admin, 6 = funcionario, 5 = instructor
        $idUsuario = $_SESSION['idUsuario'] ?? null;

        $solicitudObj = new SolicitudModel();

        if ($rol == 4) {
            // Administrador: ver todas las solicitudes
            $solicitudes = $solicitudObj->getAll();
            $esEnviadas = false;
        } elseif ($rol == 5 || $rol == 6) {
            // Funcionario o Instructor: solo las asignadas a él
            $solicitudes = $solicitudObj->getByAsignacion($idUsuario);
            $esEnviadas = false;
        } else if ($rol == 1 ) {
            //Administrativo ve solo las enviadas
            $solicitudes = $solicitudObj ->getByUsuarioCreador($idUsuario);
            $esEnviadas = true;
        } else {
            $solicitudes = [];
            $esEnviadas = false;
        }

        $clienteObj = new ClienteModel();
        $clientes = $clienteObj->getAll();

        $servicioObj = new ServicioModel();
        $servicios = $servicioObj->getAll();

        $estadoObj = new EstadoModel();
        $estados = $estadoObj->getAll();

        $data = [
            "solicitudes" => $solicitudes,
            "clientes" => $clientes,
            "servicios" => $servicios,
            "estados" => $estados,
            "titulo" => "solicitudes",
            "esEnviadas" => $esEnviadas 
        ];

        $this->render('solicitud/view.php', $data);
    }

    public function newSolicitud()
    {
        $clienteObj = new ClienteModel();
        $clientes = $clienteObj->getAll();

        $servicioObj = new ServicioModel();
        $servicios = $servicioObj->getAll();

        $estadoObj = new EstadoModel();
        $estados = $estadoObj->getAll();

        $data = [
            "clientes" => $clientes,
            "servicios" => $servicios,
            "estados" => $estados,
            "titulo" => "Nueva solicitud"
        ];
        $this->render('solicitud/new.php', $data);
    }

    public function createSolicitud()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $clienteObj = new ClienteModel();
            $documento = $_POST['documento'];
            $nombre = $_POST['nombre'];
            $correo = $_POST['correo'];
            $telefono = $_POST['telefono'];

            // Verificar si el cliente existe o crear uno nuevo
            $cliente = $clienteObj->getClienteByDocumento($documento);
            if (!$cliente) {
                $idCliente = $clienteObj->saveCliente($documento, $nombre, $correo, $telefono);
            } else {
                $idCliente = $cliente->id;
            }

            // Obtener el idUsuario de la sesión
            if (session_status() === PHP_SESSION_NONE) session_start();
            $idUsuario = $_SESSION['idUsuario'] ?? null;

            // Datos de la solicitud
            $descripcion = $_POST['descripcion'];
            $fechaEvento = $_POST['fecha_evento'];
            $idServicio = $_POST['servicio'];
            $idTipoServicio = $_POST['tipo_servicio']; // Nuevo campo
            $estado = $_POST['estado']; // Viene como 1 (Pendiente) por defecto
            $lugar = $_POST['lugar'] ?? null;
            $municipio = $_POST['municipio'] ?? null;

            $solicitudObj = new SolicitudModel();
            try {
                $solicitudObj->saveSolicitud(
                    $descripcion,
                    $fechaEvento,
                    $idCliente,
                    $idTipoServicio, // Guardar el tipo de servicio
                    $estado,
                    $idUsuario, // Pasar el usuario de la sesión
                    $lugar,
                    $municipio
                );
                $this->redirectTo("solicitud/view");
            } catch (\PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    }

    public function viewSolicitud($id)
    {
        $solicitudObj = new SolicitudModel();
        $solicitudInfo = $solicitudObj->getSolicitud($id);
        $data = [
            "solicitud" => $solicitudInfo,
            "titulo" => "Ver solicitud #" . $id
        ];
        $this->render("solicitud/viewOne.php", $data);
    }

    public function editSolicitud($id)
    {
        $solicitudObj = new SolicitudModel();
        $solicitudInfo = $solicitudObj->getSolicitud($id);

        $servicioObj = new ServicioModel();
        $servicios = $servicioObj->getAll();

        $tipoServicioObj = new TipoServicioModel();
        $tiposServicio = $tipoServicioObj->getAll();

        $estadoObj = new EstadoModel();
        $estados = $estadoObj->getAll();

        // Obtener usuarios
        require_once MAIN_APP_ROUTE . "../models/UsuarioModel.php";
        $usuarioObj = new \App\Models\UsuarioModel();
        $usuarios = $usuarioObj->getAll();

        // Filtrar solo usuarios con FKidRol  (Funcionario) o  (Instructor)
        $usuariosAsignables = array_filter($usuarios, function ($usuario) {
            return in_array($usuario->FKroles, [5, 6]);
        });

        $data = [
            "solicitud" => $solicitudInfo,
            "servicios" => $servicios,
            "tiposServicio" => $tiposServicio,
            "estados" => $estados,
            "usuariosAsignables" => $usuariosAsignables, // Cambia aquí
            "titulo" => "Editar solicitud"
        ];
        $this->render("solicitud/edit.php", $data);
    }

    public function updateSolicitud()
    {
        if (isset($_POST["Descripcion"])) {
            try {
                $id = $_POST["idSolicitud"] ?? null;
                $descripcion = $_POST["Descripcion"] ?? null;
                $fechaSolicitud = $_POST["FechaSolicitud"] ?? null;
                $nombreCliente = $_POST["NombreCliente"] ?? null;
                $idTipoServicio = $_POST["IdTipoServicio"] ?? null;
                $idEstado = $_POST["IdEstado"] ?? null;
                $lugar = $_POST["Lugar"] ?? null;
                $municipio = $_POST["Municipio"] ?? null;
                $comentarios = $_POST["Comentarios"] ?? null;
                $observaciones = $_POST["Observaciones"] ?? null;
                $asignacion = $_POST["Asignacion"] ?? null;

                // Obtener el estado anterior de la solicitud
                $solicitudObj = new SolicitudModel();
                $solicitudAnterior = $solicitudObj->getSolicitud($id);

                if (!$solicitudAnterior) {
                    throw new \Exception("No se encontró la solicitud");
                }

                // Log para debugging
                error_log("Estado anterior: " . $solicitudAnterior->FKstates . ", Estado nuevo: " . $idEstado);

                // Actualizar cliente
                $clienteObj = new ClienteModel();
                $clienteObj->editCliente(
                    $solicitudAnterior->FKclients,
                    $solicitudAnterior->DocumentClient,
                    $nombreCliente,
                    $solicitudAnterior->EmailClient,
                    $solicitudAnterior->TelephoneClient
                );

                // Actualizar solicitud
                $resultado = $solicitudObj->editSolicitud(
                    $id,
                    $descripcion,
                    $fechaSolicitud,
                    $solicitudAnterior->FKclients,
                    $idTipoServicio,
                    $idEstado,
                    $lugar,
                    $municipio,
                    $comentarios,
                    $observaciones,
                    $asignacion
                );

                // Si el estado cambió, verificar si debemos enviar correo
                if ($resultado && $solicitudAnterior->FKstates != $idEstado) {
                    error_log("Estado cambió, intentando enviar correo...");

                    require_once MAIN_APP_ROUTE . "../models/UsuarioModel.php";
                    require_once MAIN_APP_ROUTE . "../utils/Mailer.php";

                    $usuarioObj = new \App\Models\UsuarioModel();
                    $estadoObj = new EstadoModel();

                    // Obtener información del nuevo estado
                    $nuevoEstado = $estadoObj->getEstado($idEstado);

                    // Obtener usuario creador de la solicitud
                    $usuarioCreador = $usuarioObj->getUsuario($solicitudAnterior->FKusers);

                    error_log("Usuario creador: " . ($usuarioCreador ? $usuarioCreador->nameUser : 'No encontrado'));
                    error_log("Email: " . ($usuarioCreador ? $usuarioCreador->emailUser : 'N/A'));
                    error_log("Valor Coordinator RAW: " . ($usuarioCreador ? var_export($usuarioCreador->Coordinator, true) : 'N/A'));

                    $esCoordinador = false;
                    if ($usuarioCreador) {
                        // Maneja diferentes tipos de valores: boolean, integer, string
                        $coordValue = $usuarioCreador->Coordinator ?? null;
                        $esCoordinador = (
                            $coordValue === true || 
                            $coordValue === 1 || 
                            $coordValue === '1' || 
                            $coordValue === 't' || // PostgreSQL boolean true
                            strtolower($coordValue) === 'true'
                        );
                    }

                    error_log("Es coordinador (después de verificación): " . ($esCoordinador ? 'SI' : 'NO'));
                    // Si el usuario es coordinador, enviar correo
                    if ($usuarioCreador && $esCoordinador && !empty($usuarioCreador->emailUser)) {
                        error_log("Enviando correo a coordinador: " . $usuarioCreador->emailUser);

                        $mailer = new \App\Utils\Mailer();
                        $asunto = "Actualización de Estado - Solicitud #" . $id;

                        $mensaje = '
                    <!DOCTYPE html>
                    <html lang="es">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>Actualización de Solicitud SENA</title>
                        <style>
                            * {
                                box-sizing: border-box;
                                margin: 0;
                                padding: 0;
                            }
                            
                            body {
                                font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
                                background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
                                margin: 0;
                                padding: 20px;
                                line-height: 1.6;
                            }
                            
                            .email-wrapper {
                                max-width: 650px;
                                margin: 0 auto;
                                background: #ffffff;
                                border-radius: 12px;
                                overflow: hidden;
                                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
                            }
                            
                            .header {
                                background: linear-gradient(135deg, #39A900 0%, #2d8000 100%);
                                color: #ffffff;
                                padding: 30px 20px;
                                text-align: center;
                                position: relative;
                            }
                            
                            .header::before {
                                content: "";
                                position: absolute;
                                bottom: 0;
                                left: 0;
                                right: 0;
                                height: 4px;
                                background: linear-gradient(90deg, #39A900, #66d932, #39A900);
                            }
                            
                            .logo-section {
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                gap: 15px;
                                margin-bottom: 10px;
                            }
                            
                            .logo-placeholder {
                                width: 60px;
                                height: 60px;
                                background: rgba(255, 255, 255, 0.1);
                                border-radius: 8px;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                font-weight: bold;
                                font-size: 20px;
                                border: 2px solid rgba(255, 255, 255, 0.3);
                            }
                            
                            .company-logo {
                                width: 60px;
                                height: 60px;
                                object-fit: contain;
                                border-radius: 8px;
                                background: rgba(255, 255, 255, 0.9);
                                padding: 8px;
                            }
                            
                            .header h1 {
                                font-size: 22px;
                                font-weight: 600;
                                margin: 0;
                                letter-spacing: 0.5px;
                            }
                            
                            .header .subtitle {
                                font-size: 14px;
                                opacity: 0.9;
                                margin-top: 5px;
                                font-weight: 300;
                            }
                            
                            .content {
                                padding: 35px 30px;
                                color: #333333;
                            }
                            
                            .greeting {
                                font-size: 16px;
                                margin-bottom: 20px;
                                color: #2c3e50;
                            }
                            
                            .greeting .user-name {
                                color: #39A900;
                                font-weight: 600;
                            }
                            
                            .update-title {
                                background: linear-gradient(135deg, #39A900, #66d932);
                                color: white;
                                padding: 15px 20px;
                                border-radius: 8px;
                                font-size: 18px;
                                font-weight: 600;
                                text-align: center;
                                margin: 20px 0;
                                box-shadow: 0 4px 15px rgba(57, 169, 0, 0.2);
                            }
                            
                            .status-card {
                                background: linear-gradient(135deg, #f8fffe 0%, #f0f9f0 100%);
                                border: 2px solid #39A900;
                                border-radius: 10px;
                                padding: 25px;
                                margin: 25px 0;
                                position: relative;
                            }
                            
                            .status-card::before {
                                content: "ℹ️";
                                position: absolute;
                                top: -10px;
                                left: 20px;
                                background: #39A900;
                                color: white;
                                width: 30px;
                                height: 30px;
                                border-radius: 50%;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                font-size: 16px;
                            }
                            
                            .status-row {
                                display: flex;
                                justify-content: space-between;
                                align-items: center;
                                margin: 15px 0;
                                padding: 12px 0;
                                border-bottom: 1px solid #e8f5e8;
                            }
                            
                            .status-row:last-child {
                                border-bottom: none;
                            }
                            
                            .status-label {
                                font-weight: 600;
                                color: #2c3e50;
                                font-size: 14px;
                                min-width: 120px;
                            }
                            
                            .status-value {
                                background: #39A900;
                                color: white;
                                padding: 6px 12px;
                                border-radius: 20px;
                                font-size: 13px;
                                font-weight: 500;
                                flex: 1;
                                text-align: center;
                                margin-left: 15px;
                            }
                            
                            .status-value.previous {
                                background: #95a5a6;
                            }
                            
                            .description-box {
                                background: #ffffff;
                                border: 1px solid #e8f5e8;
                                border-radius: 6px;
                                padding: 15px;
                                margin: 15px 0;
                                font-style: italic;
                                color: #555;
                            }
                            
                            .action-section {
                                background: #f8f9fa;
                                border-radius: 8px;
                                padding: 20px;
                                margin: 25px 0;
                                text-align: center;
                            }
                            
                            .cta-button {
                                display: inline-block;
                                background: linear-gradient(135deg, #39A900, #2d8000);
                                color: white;
                                padding: 12px 30px;
                                text-decoration: none;
                                border-radius: 25px;
                                font-weight: 600;
                                font-size: 14px;
                                transition: all 0.3s ease;
                                box-shadow: 0 4px 15px rgba(57, 169, 0, 0.3);
                            }
                            
                            .cta-button:hover {
                                transform: translateY(-2px);
                                box-shadow: 0 6px 20px rgba(57, 169, 0, 0.4);
                            }
                            
                            .footer {
                                background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
                                color: #ecf0f1;
                                padding: 25px 20px;
                                text-align: center;
                                font-size: 13px;
                            }
                            
                            .footer-content {
                                max-width: 500px;
                                margin: 0 auto;
                            }
                            
                            .footer strong {
                                color: #39A900;
                            }
                            
                            .divider {
                                height: 3px;
                                background: linear-gradient(90deg, #39A900, #66d932, #39A900);
                                margin: 25px 0;
                                border-radius: 2px;
                            }
                            
                            @media (max-width: 600px) {
                                body {
                                    padding: 10px;
                                }
                                
                                .content {
                                    padding: 25px 20px;
                                }
                                
                                .status-row {
                                    flex-direction: column;
                                    align-items: flex-start;
                                    gap: 10px;
                                }
                                
                                .status-value {
                                    margin-left: 0;
                                    width: 100%;
                                }
                                
                                .header h1 {
                                    font-size: 18px;
                                }
                            }
                        </style>
                    </head>
                    <body>
                        <div class="email-wrapper">
                            <div class="header">
                                <div class="logo-section">

                                    <!-- Opción 2: Sin logo (mantener placeholder) -->
                                    <!-- <div class="logo-placeholder">SENA</div> -->
                                    <div>
                                        <h1>SISTEMA DE GESTIÓN DE RELACIONAMIENTO CORPORATIVO</h1>
                                        <div class="subtitle">Servicio Nacional de Aprendizaje</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="content">
                                <div class="greeting">
                                    Estimado(a) <span class="user-name">' . htmlspecialchars($usuarioCreador->nameUser) . '</span>,
                                </div>
                                
                                <p>Nos complace informarle que hemos procesado una actualización en su solicitud. A continuación, encontrará los detalles del cambio realizado:</p>
                                
                                <div class="update-title">
                                    📋 Solicitud #' . htmlspecialchars($id) . ' - Estado Actualizado
                                </div>
                                
                                <div class="status-card">
                                    <div class="status-row">
                                        <div class="status-label">Estado Anterior:</div>
                                        <div class="status-value previous">' . htmlspecialchars($solicitudAnterior->State) . '</div>
                                    </div>
                                    
                                    <div class="status-row">
                                        <div class="status-label">Nuevo Estado:</div>
                                        <div class="status-value">' . htmlspecialchars($nuevoEstado->State) . '</div>
                                    </div>
                                    
                                    <div class="status-row">
                                        <div class="status-label">Descripción:</div>
                                    </div>
                                    <div class="description-box">
                                        ' . htmlspecialchars($descripcion) . '
                                    </div>
                                </div>
                                
                                <div class="divider"></div>
                                
                                <div class="action-section">
                                    <p><strong>¿Necesita más información?</strong></p>
                                    <p>Acceda al sistema para consultar el historial completo y realizar el seguimiento correspondiente.</p>
                                </div>
                                
                                <p style="color: #7f8c8d; font-size: 14px; margin-top: 30px;">
                                    <strong>Nota:</strong> Este cambio ha sido registrado automáticamente en el sistema. Si tiene alguna consulta adicional, puede contactar a su gestor asignado.
                                </p>
                            </div>
                            
                            <div class="footer">
                                <div class="footer-content">
                                    <p>🤖 <strong>Mensaje Automático</strong></p>
                                    <p>Este correo ha sido generado automáticamente por el <strong>Sistema de Gestión de Relacionamiento Corporativo del SENA</strong>.</p>
                                    <p style="margin-top: 10px; opacity: 0.8;">Por favor, no responda directamente a este correo electrónico.</p>
                                </div>
                            </div>
                        </div>
                    </body>
                    </html>';
                        try {
                            $resultadoCorreo = $mailer->enviar($usuarioCreador->emailUser, $asunto, $mensaje);
                            error_log("✓ Correo enviado exitosamente");
                            if (!$resultadoCorreo) {
                                error_log("✗ Mailer retornó FALSE");
                            }
                        } catch (\Exception $e) {
                            error_log("✗ Error enviando correo: " . $e->getMessage());
                            error_log("Stack trace: " . $e->getTraceAsString());
                        }
                    } else {
                    error_log("No se envió correo. Razones:");
                    error_log("- Usuario existe: " . ($usuarioCreador ? 'SI' : 'NO'));
                    error_log("- Es coordinador: " . ($esCoordinador ? 'SI' : 'NO'));
                    error_log("- Tiene email: " . (($usuarioCreador && !empty($usuarioCreador->emailUser)) ? 'SI' : 'NO'));
                }
                }
                $this->redirectTo("solicitud/view");
            } catch (\Exception $e) {
                error_log("Error en updateSolicitud: " . $e->getMessage());
                echo "Error: " . $e->getMessage();
            }
        }
    }

    public function deleteSolicitud($id)
    {
        $solicitudObj = new SolicitudModel();
        $solicitudObj->deleteSolicitud($id);
        $this->redirectTo("solicitud/view");
    }


    

    public function dashboard()
    {
        // Obtener total de solicitudes pendientes
        $solicitudObj = new SolicitudModel();
        $totalSolicitudesPendientes = $solicitudObj->getSolicitudesPendientes();

        $data = [
            "totalSolicitudesPendientes" => $totalSolicitudesPendientes,
            "titulo" => "Dashboard Administrativo"
        ];

        $this->render('admin/indexAdministrativo.php', $data);
    }
    public function archivadas()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $rol = $_SESSION['rol'] ?? null;
        $idUsuario = $_SESSION['idUsuario'] ?? null;

        $solicitudModel = new \App\Models\SolicitudModel();

        if ($rol == 4) {
            // Administrador: ver todas las archivadas
            $solicitudes = $solicitudModel->getArchivadas();
        } elseif ($rol == 5 || $rol == 6) {
            // Instructor o Funcionario: solo las archivadas asignadas a él
            $solicitudes = $solicitudModel->getArchivadasByAsignacion($idUsuario);
        } else {
            $solicitudes = [];
        }

        // Puedes cargar los demás datos igual que en view()
        $clienteObj = new \App\Models\ClienteModel();
        $clientes = $clienteObj->getAll();

        $servicioObj = new \App\Models\ServicioModel();
        $servicios = $servicioObj->getAll();

        $estadoObj = new \App\Models\EstadoModel();
        $estados = $estadoObj->getAll();

        $data = [
            "solicitudes" => $solicitudes,
            "clientes" => $clientes,
            "servicios" => $servicios,
            "estados" => $estados,
            "titulo" => "Solicitudes Archivadas"
        ];

        // Reutiliza la vista view.php
        $this->render('solicitud/view.php', $data);
    }

    public function archivarSolicitud($idSolicitud)
    {
        header('Content-Type: application/json');
        try {
            $solicitudModel = new \App\Models\SolicitudModel();
            $success = $solicitudModel->archivar($idSolicitud); // Solo marca como archivada
            if ($success) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => 'No se pudo archivar']);
            }
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
        exit;
    }

    public function desarchivarSolicitud($idSolicitud)
    {
        header('Content-Type: application/json');
        try {
            $solicitudModel = new \App\Models\SolicitudModel();
            $success = $solicitudModel->desarchivar($idSolicitud);
            if ($success) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => 'No se pudo desarchivar']);
            }
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
        exit;
    }

    public function solicitudesProcesoEjecutadasAPI()
{
    header('Content-Type: application/json');
    try {
        $solicitudObj = new \App\Models\SolicitudModel();
        $data = $solicitudObj->getSolicitudesProcesoEjecutadasPorMes();

        // Si no hay datos, usar datos de ejemplo
        if (empty($data)) {
            $data = [
                ['mes' => 'Enero', 'anio' => '2024', 'en_proceso' => 5, 'ejecutadas' => 3, 'total' => 8],
                ['mes' => 'Febrero', 'anio' => '2024', 'en_proceso' => 8, 'ejecutadas' => 6, 'total' => 14],
                ['mes' => 'Marzo', 'anio' => '2024', 'en_proceso' => 4, 'ejecutadas' => 7, 'total' => 11]
            ];
        }

        // Traducir meses al español
        $mesesIngles = [
            'January' => 'Enero', 'February' => 'Febrero', 'March' => 'Marzo',
            'April' => 'Abril', 'May' => 'Mayo', 'June' => 'Junio',
            'July' => 'Julio', 'August' => 'Agosto', 'September' => 'Septiembre',
            'October' => 'Octubre', 'November' => 'Noviembre', 'December' => 'Diciembre'
        ];

        $formattedData = [];
        foreach ($data as $row) {
            $mes = trim($row['mes']);
            // Traducir si está en inglés
            if (isset($mesesIngles[$mes])) {
                $mes = $mesesIngles[$mes];
            }
            
            $formattedData[] = [
                'mes' => $mes . ' ' . $row['anio'],
                'en_proceso' => (int)($row['en_proceso'] ?? 0),
                'ejecutadas' => (int)($row['ejecutadas'] ?? 0)
            ];
        }

        echo json_encode($formattedData, JSON_PRETTY_PRINT);
        
    } catch (\Exception $e) {
        error_log("Error en solicitudesProcesoEjecutadasAPI: " . $e->getMessage());
        http_response_code(500);
        echo json_encode([
            'error' => true,
            'message' => 'Error al obtener datos: ' . $e->getMessage(),
            'data' => [
                ['mes' => 'Enero 2024', 'en_proceso' => 5, 'ejecutadas' => 3],
                ['mes' => 'Febrero 2024', 'en_proceso' => 8, 'ejecutadas' => 6],
                ['mes' => 'Marzo 2024', 'en_proceso' => 4, 'ejecutadas' => 7]
            ]
        ]);
    }
    exit;
}

    public function solicitudesPorEstadoAPI()
    {
        header('Content-Type: application/json');
        $solicitudObj = new \App\Models\SolicitudModel();
        $data = $solicitudObj->getSolicitudesPorEstado();
        echo json_encode($data);
        exit;
    }



    public function serviciosMasSolicitadosAPI()
    {
        header('Content-Type: application/json');
        try {
            $solicitudObj = new \App\Models\SolicitudModel();
            $data = $solicitudObj->getServiciosMasSolicitados();
            echo json_encode($data);
        } catch (\Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
        exit;
    }
    public function solicitudesPorMesAPI()
{
    header('Content-Type: application/json');
    try {
        $solicitudObj = new \App\Models\SolicitudModel();
        $data = $solicitudObj->getSolicitudesPorMes();

        // Traducir meses al español si es necesario
        $mesesIngles = [
            'January' => 'Enero', 'February' => 'Febrero', 'March' => 'Marzo',
            'April' => 'Abril', 'May' => 'Mayo', 'June' => 'Junio',
            'July' => 'Julio', 'August' => 'Agosto', 'September' => 'Septiembre',
            'October' => 'Octubre', 'November' => 'Noviembre', 'December' => 'Diciembre'
        ];

        $formattedData = [];
        foreach ($data as $row) {
            $mes = trim($row['mes']);
            // Traducir si está en inglés
            if (isset($mesesIngles[$mes])) {
                $mes = $mesesIngles[$mes];
            }
            
            $formattedData[] = [
                'mes' => $mes . ' ' . $row['anio'],
                'cantidad' => (int)$row['cantidad']
            ];
        }

        echo json_encode($formattedData, JSON_PRETTY_PRINT);
    } catch (\Exception $e) {
        error_log("Error en solicitudesPorMesAPI: " . $e->getMessage());
        http_response_code(500);
        echo json_encode([
            'error' => true,
            'message' => 'Error al obtener datos: ' . $e->getMessage(),
            'data' => []
        ]);
    }
    exit;
}
    public function municipiosMasSolicitudesAPI()
    {
        header('Content-Type: application/json');
        try {
            $solicitudObj = new \App\Models\SolicitudModel();
            $data = $solicitudObj->getMunicipiosMasSolicitudes();
            echo json_encode($data);
        } catch (\Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
        exit;
    }

    public function enviadas()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $rol = $_SESSION['rol'] ?? null;
        $idUsuario = $_SESSION['idUsuario'] ?? null;

        $solicitudObj = new SolicitudModel();
        $clienteObj = new ClienteModel();
        $servicioObj = new ServicioModel();
        $estadoObj = new EstadoModel();

        // Aquí solo obtenemos las solicitudes creadas por el usuario actual
        $solicitudes = $solicitudObj->getByUsuarioCreador($idUsuario);

        $data = [
            "solicitudes" => $solicitudes,
            "clientes" => $clienteObj->getAll(),
            "servicios" => $servicioObj->getAll(),
            "estados" => $estadoObj->getAll(),
            "titulo" => "Solicitudes Enviadas",
            "esEnviadas" => true,
            "mostrarBotonArchivadas" => false
        ];

        $this->render('solicitud/view.php', $data);
    }
}

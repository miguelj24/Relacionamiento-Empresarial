<?php
namespace App\Controllers;

use App\Utils\Mailer;

class PasswordController extends BaseController {
    
    public function __construct() {
        parent::__construct();
        $this->layout = "login_layout";
    }
    
    public function showForgotForm() {
        $this->render("password/forgot.php");
    }

    public function requestReset() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'Por favor, ingresa un correo electrónico válido.'
                ]);
                exit;
            }

            try {
                $response = $this->callResetPasswordAPI($email);
                header('Content-Type: application/json');
                
                echo json_encode([
                    'success' => $response['success'],
                    'message' => 'Se han enviado las instrucciones a tu correo electrónico.'
                ]);
                exit;
                
            } catch (\Exception $e) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'Ocurrió un error al procesar tu solicitud. Por favor, intenta más tarde.'
                ]);
                exit;
            }
        } else {
            // Si es GET, mostrar el formulario
            $this->render("password/forgot.php");
        }
    }

    public function resetPassword() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->render("password/reset.php");
            return;
        }

        $token = $_POST['token'] ?? '';
        $password = $_POST['password'] ?? '';
        $passwordConfirmation = $_POST['password_confirmation'] ?? '';

        // Validaciones
        if (empty($token) || empty($password) || empty($passwordConfirmation)) {
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'error',
                'success' => false,
                'message' => 'Todos los campos son requeridos'
            ]);
            exit;
        }

        if ($password !== $passwordConfirmation) {
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'error',
                'success' => false,
                'message' => 'Las contraseñas no coinciden'
            ]);
            exit;
        }

        // Validar longitud mínima de contraseña
        if (strlen($password) < 8) {
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'error',
                'success' => false,
                'message' => 'La contraseña debe tener al menos 8 caracteres'
            ]);
            exit;
        }

        try {
            $response = $this->callResetPasswordConfirmAPI($token, $password);
            header('Content-Type: application/json');
            
            // Devolver respuesta clara
            echo json_encode([
                'status' => $response['success'] ? 'success' : 'error',
                'success' => $response['success'],
                'message' => $response['message']
            ]);
            exit;
            
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'error',
                'success' => false,
                'message' => 'Error al procesar la solicitud: ' . $e->getMessage()
            ]);
            exit;
        }
    }

    private function callResetPasswordConfirmAPI($token, $password) {
        $apiUrl = "https://adso711-sisrel-94jo.onrender.com/api/v1/auth/reset-password";
        
        // Intentar con diferentes nombres de campos que podría esperar el API
        $data = [
            'token' => $token,
            'resetPasswordToken' => $token,
            'newPassword' => $password,
            'passwordUser' => $password,
            'password' => $password
        ];

        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json'
        ]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($ch);
        
        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            throw new \Exception('Error de conexión: ' . $error);
        }
        
        curl_close($ch);
        
        $result = json_decode($response, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            return [
                'success' => false,
                'message' => 'Error al decodificar la respuesta de la API'
            ];
        }

        // Verificar si el mensaje indica éxito (es lo más importante)
        $message = $result['message'] ?? $result['error'] ?? $result['msg'] ?? 'Error desconocido';
        $messageLower = strtolower($message);
        
        // La lógica es simple: si el mensaje contiene estas palabras, es exitoso
        $success = (strpos($messageLower, 'actualizado') !== false || 
                    strpos($messageLower, 'exitoso') !== false ||
                    strpos($messageLower, 'success') !== false ||
                    strpos($messageLower, 'actualizada') !== false);

        return [
            'success' => $success,
            'message' => $message
        ];
    }

    private function getResetEmailTemplate($resetLink) {
        return "
            <h2>Recuperación de Contraseña</h2>
            <p>Has solicitado restablecer tu contraseña. Haz clic en el siguiente enlace para continuar:</p>
            <p><a href='{$resetLink}'>Restablecer Contraseña</a></p>
            <p>Este enlace expirará en 1 hora.</p>
            <p>Si no solicitaste este cambio, puedes ignorar este correo.</p>
        ";
    }

    private function callResetPasswordAPI($email) {
        $apiUrl = "https://adso711-sisrel-94jo.onrender.com/api/v1/auth/forgot-password";
        
        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
            'email' => $email
        ]));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        
        if (curl_errno($ch)) {
            throw new \Exception('Error en la llamada API: ' . curl_error($ch));
        }
        
        curl_close($ch);
        
        $result = json_decode($response, true);
        
        // Verificar si la respuesta es válida
        if (!$result) {
            throw new \Exception('Error al decodificar la respuesta de la API');
        }
        
        // Verificar éxito de múltiples formas
        $success = false;
        $message = $result['message'] ?? $result['error'] ?? $result['msg'] ?? '';
        $messageLower = strtolower($message);
        
        // Buscar palabras clave de éxito en el mensaje
        if (strpos($messageLower, 'enviado') !== false || 
            strpos($messageLower, 'enviadas') !== false ||
            strpos($messageLower, 'success') !== false ||
            strpos($messageLower, 'exitoso') !== false) {
            $success = true;
        }
        // O verificar el status
        elseif (isset($result['status']) && ($result['status'] === 'success' || $result['status'] === 200)) {
            $success = true;
        }
        
        return [
            'success' => $success,
            'token' => $result['resetPasswordToken'] ?? null,
            'message' => $message
        ];
    }
}
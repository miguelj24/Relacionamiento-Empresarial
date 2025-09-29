<?php
namespace App\Utils;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer {
    private $mail;

    public function __construct() {
        $this->mail = new PHPMailer(true);
        try {
            // Configuración del servidor SMTP de Gmail
            $this->mail->isSMTP();
            $this->mail->Host       = 'smtp.gmail.com';
            $this->mail->SMTPAuth   = true;
            $this->mail->Username   = 'sisrelnotification@gmail.com';
            $this->mail->Password   = 'eudnalwuxczomzuo'; // Cambiar por contraseña de aplicación
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mail->Port       = 587;
            
            // Habilitar debug (temporal para diagnosticar)
            $this->mail->SMTPDebug = 2; // Cambiar a 0 en producción
            $this->mail->Debugoutput = 'error_log';

            // Remitente
            $this->mail->setFrom('sisrelnotification@gmail.com', 'SISREL');
            
        } catch (Exception $e) {
            error_log("Error configurando PHPMailer: " . $e->getMessage());
            throw new \Exception("Error configurando PHPMailer: " . $e->getMessage());
        }
    }

    public function enviar($para, $asunto, $mensajeHtml) {
        try {
            $this->mail->clearAddresses();
            $this->mail->addAddress($para);

            $this->mail->isHTML(true);
            $this->mail->Subject = $asunto;
            $this->mail->Body    = $mensajeHtml;
            $this->mail->CharSet = 'UTF-8';

            $resultado = $this->mail->send();
            error_log("Correo enviado exitosamente a: " . $para);
            return $resultado;
            
        } catch (Exception $e) {
            error_log("Error enviando correo a {$para}: " . $e->getMessage());
            error_log("PHPMailer Debug: " . $this->mail->ErrorInfo);
            throw new \Exception("Error enviando correo: " . $e->getMessage());
        }
    }
}
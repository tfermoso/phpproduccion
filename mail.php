<?php
// Importar la clase de PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Cargar la biblioteca PHPMailer
require 'vendor/autoload.php';

// Crear una nueva instancia de PHPMailer
$mail = new PHPMailer(true);

try {
    // Configurar el servidor SMTP
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'cursoceica2024@gmail.com'; // Tu dirección de correo de Gmail
    $mail->Password   = 'Ceica23$';       // Tu contraseña de Gmail
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    // Configurar remitente y destinatario
    $mail->setFrom('cursoceica@gmail.com', 'Tomas');
    $mail->addAddress('tomas.fermoso@gmail.com', 'Tomas Fermoso');

    // Contenido del correo
    $mail->isHTML(true);
    $mail->Subject = 'Asunto del correo';
    $mail->Body    = 'Este es el cuerpo del correo. Puedes usar HTML aquí.';

    // Enviar el correo
    $mail->send();
    echo 'El correo se envió correctamente.';
} catch (Exception $e) {
    echo "No se pudo enviar el correo. Error: {$mail->ErrorInfo}";
}
?>

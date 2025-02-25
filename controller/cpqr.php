<?php
require_once "../model/conexion.php";
require_once "../model/mpqr.php";
require_once "../config/config.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "../vendor/autoload.php";

$idpqr = isset($_POST['idpqr']) ? $_POST['idpqr'] : null;
$emausu = isset($_POST['emausu']) ? $_POST['emausu'] : null;
$tippqr = isset($_POST['tippqr']) ? $_POST['tippqr'] : null;
$mensaje = isset($_POST['mensaje']) ? $_POST['mensaje'] : null;
$nomusu = isset($_POST['nomusu']) ? $_POST['nomusu'] : null;
$idusu = isset($_POST['idusu']) ? $_POST['idusu'] : null;
$idprov = isset($_POST['idprov']) ? $_POST['idprov'] : null;
$respuesta = isset($_POST['respuesta']) ? $_POST['respuesta'] : null;
$msjUser = isset($_POST['pqrMensaje']) ? $_POST['pqrMensaje'] : null;

$acc = isset($_POST['acc']) ? $_POST['acc'] : null;
$mpqr = new Mpqr();

$mpqr->setEmausu($emausu);
$mpqr->setTippqr($tippqr);
$mpqr->setMensaje($mensaje);
$mpqr->setNomusu($nomusu);
$mpqr->setIdusu($idusu);
$mpqr->setIdprov($idprov);

if ($acc == "res") {
    $mpqr->setIdpqr($idpqr);
    $mpqr->setRespuesta($respuesta);

    if ($mpqr->guardarRespuesta()) {
        $cuerpoCorreo = generarCuerpoCorreo($nomusu, $emausu, $msjUser, $respuesta);
        if (enviarCorreo($emausu, "Respuesta a la solicitud (PQR)", $cuerpoCorreo)) {
            echo "<h5>Respuesta enviada correctamente.</h5><p>Gracias por preferirnos</p>";
        }
        ?>
        <script>
            setTimeout(function () {
                window.location.href = "../views/admin.php";
            }, 2000);
        </script>
        <?php

    }
} else {
    if ($mpqr->savePqr()) {
        $cuerpoCorreo = generarCuerpoCorreo($nomusu, $emausu, $mensaje);
        if (enviarCorreo($emausu, "Solicitud de PQR", $cuerpoCorreo)) {
            echo "<h5>PQR radicado correctamente.</h5><p>Le enviamos un mensaje de confirmación al correo $emausu</p>";
        } else {
            echo "No se ha registrado tu PQR, vuelve a intentarlo.";
        }
    }
    ?>
    <script>
        setTimeout(function () {
            window.location.href = "<?php echo isset($_SESSION['idusu']) ? '../home.php?pg=8' : '../index.php?pg=8'; ?>";
        }, 5000);
    </script>
    <?php

}

function enviarCorreo($para, $asunto, $cuerpo)
{
    $mail = new PHPMailer(true);
    $mail->CharSet = 'UTF-8';

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = MAIL_USER;
        $mail->Password = MAIL_PASS;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->setFrom(MAIL_USER, 'Soporte SHOOP');
        $mail->addAddress($para);
        $mail->addReplyTo(MAIL_USER, 'Equipo SHOOP');
        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->addBCC('davidscicua314@gmail.com');
        $mail->Body = $cuerpo;

        $mail->send();
        return true;
    } catch (\Exception $e) {
        error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
        return false;
    }
}

function generarCuerpoCorreo($nomusu, $emausu, $mensajeUsuario, $respuesta = null)
{
    $cuerpo = "
    <html>
    <head>
    <style>
        .email-wrapper { width: 100%; max-width: 600px; margin: 0 auto; }
        .email-container { background-color: #ffffff; border: 1px solid #ddd; padding: 20px; border-radius: 8px; }
        h1 { font-size: 24px; }
        .footer { font-size: 12px; margin-top: 20px; }
    </style>
    </head>
    <body>
    <div class='email-wrapper'>
        <div class='email-container'>
            <h1>¡Hola, $nomusu!</h1>
            <p>Hemos recibido tu solicitud en el sistema de PQR de <strong>SHOOP</strong>.</p>";

    if ($respuesta) {
        $cuerpo .= "
            <blockquote style='border-left: 4px solid #0d6efd; padding-left: 10px;'>
                <strong>Tu mensaje:</strong> <br>
                <em>$mensajeUsuario</em>
            </blockquote>
            <blockquote style='border-left: 4px solid #28a745; padding-left: 10px;'>
                <strong>Nuestra respuesta:</strong> <br>
                <em>$respuesta</em>
            </blockquote>";
    } else {
        $cuerpo .= "
            <p>Tu petición ha sido registrada exitosamente. Nuestro equipo la revisará y te notificaremos tan pronto como tengamos una resolución.</p>
            <p>La respuesta será enviada al correo electrónico asociado a tu cuenta: <strong>$emausu</strong>.</p>";
    }

    $cuerpo .= "
            <p>Si necesitas más información o tienes dudas adicionales, no dudes en responder a este mensaje o contactarnos a través de <a href='mailto:toshoop2024@gmail.com'>toshoop2024@gmail.com</a>.</p>

            <p><strong>Importante:</strong> Si no realizaste esta solicitud o crees que hubo un error, por favor ignora este mensaje.</p>

            <p>Gracias por confiar en nosotros,<br>El equipo de <strong>SHOOP</strong></p>
        </div>
    </div>
    </body>
    </html>";

    return $cuerpo;
}

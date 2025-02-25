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
$idusu = isset($_POST['idusu']) ? $_POST['idusu'] : 0;
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
        $mail = new PHPMailer(true);
        $mail->CharSet = 'UTF-8';
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = MAIL_USER; // Define EMAIL_USER en config.php
            $mail->Password = MAIL_PASS; // Define EMAIL_PASS en config.php
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->setFrom(MAIL_USER, 'Soporte SHOOP');
            $mail->addAddress($emausu);
            $mail->addReplyTo(MAIL_USER, 'Equipo SHOOP');
            $mail->isHTML(true); // Setear formato HTML
            $mail->Subject = 'Respuesta a la solicitud (PQR)';
            $mail->addBCC('davidscicua314@gmail.com');
            $mail->Body = "<html>
    <head>
    <style>
    .email-wrapper {
        width: 100%;
        max-width: 600px;
        margin: 0 auto;
    }
    
    .email-container {
        width: 100%;
        background-color: #ffffff;
        border: 1px solid #ddd;
        padding: 20px;
        border-radius: 8px;
    }
    
    h1 {
        color: inherit;
        font-size: 24px;
    }
    
    .btn {
        display: inline-block;
        background-color: #3CB179;
        color: white !important;
        padding: 12px 24px;
        text-decoration: none;
        border-radius: 5px;
        margin: 20px 0;
        font-weight: bold;
    }
    
    .btn:hover {
        background-color: #2e8c63;
        color: white;
    }
    
    
    a:hover {
        color:rgb(223, 113, 93);
        text-decoration: underline;
    }
    
    .link {
        word-wrap: break-word;
    }
    
    .footer {
        font-size: 12px;
        margin-top: 20px;
    }
    
    /* Estilos para el modo claro (light mode) */
    @media (prefers-color-scheme: light) {
        body {
            background-color: #f4f4f4;
            color: #333;
        }
    
        .email-container {
            background-color: #ffffff;
            border-color: #ddd;
        }
    
        .footer {
            color: #777;
        }
    }
    
    /* Estilos para el modo oscuro (dark mode) */
    @media (prefers-color-scheme: dark) {
        body {
            background-color: #181818;
            color: #e0e0e0;
        }
    
        .email-container {
            background-color: #2b2b2b;
            border-color: #444;
        }
    
        .footer {
            color: #aaa;
        }
    
        a {
            color: #78e08f;
        }
    
        a:hover {
            color: #58b67f;
        }
    
        .btn {
            background-color: #78e08f;
            color: #181818;
        }
    
        .btn:hover {
            background-color: #58b67f;
            color: #181818;
        }
    }
    </style>
    </head>
    <body>
    <div class='email-wrapper'>
        <div class='email-container'>
            <h1>¡Hola, $nomusu!</h1>
            <p>Hemos revisado tu solicitud en el sistema de PQR de <strong>SHOOP</strong>. A continuación, encontrarás nuestra respuesta:</p>

            <blockquote style='border-left: 4px solid #0d6efd; padding-left: 10px; color: #555;'>
                <strong>Tu mensaje:</strong> <br>
                <em>$msjUser</em>
            </blockquote>

            <blockquote style='border-left: 4px solid #28a745; padding-left: 10px; color: #333;'>
                <strong>Nuestra respuesta:</strong> <br>
                <em>$respuesta</em>
            </blockquote>

            <p>Si necesitas más información o tienes dudas adicionales, no dudes en responder a este mensaje o contactarnos a través de <a href='mailto:toshoop2024@gmail.com'>toshoop2024@gmail.com</a>.</p>

            <p><strong>Importante:</strong> Si no realizaste esta solicitud o crees que hubo un error, por favor ignora este mensaje.</p>

            <p>Gracias por confiar en nosotros,<br>El equipo de <strong>SHOOP</strong></p>
        </div>
    </div>
    </body>
    </html>";
            $mail->send();
        } catch (\Exception $e) {
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
        }
        echo "<h5>Respuesta enviada correctamente.</h5>";
        echo "<p>Gracias por preferirnos</p>";
    }
    ?>
    <script>
        setTimeout(function () {
            window.location.href = "../views/admin.php";
        }, 2000);
    </script>
    <?php
} else {
    if ($mpqr->savePqr()) {
        $mail = new PHPMailer(true);
        $mail->CharSet = 'UTF-8';
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = MAIL_USER; // Define EMAIL_USER en config.php
            $mail->Password = MAIL_PASS; // Define EMAIL_PASS en config.php
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->setFrom(MAIL_USER, 'Soporte SHOOP');
            $mail->addAddress($emausu);
            $mail->isHTML(true); // Setear formato HTML
            $mail->Subject = 'Solicitud de PQR';
            $mail->addBCC('davidscicua314@gmail.com');
            $mail->Body = "<html>
    <head>
    <style>
    .email-wrapper {
        width: 100%;
        max-width: 600px;
        margin: 0 auto;
    }
    
    .email-container {
        width: 100%;
        background-color: #ffffff;
        border: 1px solid #ddd;
        padding: 20px;
        border-radius: 8px;
    }
    
    h1 {
        color: inherit;
        font-size: 24px;
    }
    
    .btn {
        display: inline-block;
        background-color: #3CB179;
        color: white !important;
        padding: 12px 24px;
        text-decoration: none;
        border-radius: 5px;
        margin: 20px 0;
        font-weight: bold;
    }
    
    .btn:hover {
        background-color: #2e8c63;
        color: white;
    }
    
    
    a:hover {
        color:rgb(223, 113, 93);
        text-decoration: underline;
    }
    
    .link {
        word-wrap: break-word;
    }
    
    .footer {
        font-size: 12px;
        margin-top: 20px;
    }
    
    /* Estilos para el modo claro (light mode) */
    @media (prefers-color-scheme: light) {
        body {
            background-color: #f4f4f4;
            color: #333;
        }
    
        .email-container {
            background-color: #ffffff;
            border-color: #ddd;
        }
    
        .footer {
            color: #777;
        }
    }
    
    /* Estilos para el modo oscuro (dark mode) */
    @media (prefers-color-scheme: dark) {
        body {
            background-color: #181818;
            color: #e0e0e0;
        }
    
        .email-container {
            background-color: #2b2b2b;
            border-color: #444;
        }
    
        .footer {
            color: #aaa;
        }
    
        a {
            color: #78e08f;
        }
    
        a:hover {
            color: #58b67f;
        }
    
        .btn {
            background-color: #78e08f;
            color: #181818;
        }
    
        .btn:hover {
            background-color: #58b67f;
            color: #181818;
        }
    }
    </style>
    </head>
    <body>
    <div class='email-wrapper'>
    <div class='email-container'>
        <h1>¡Hola, $nomusu!</h1>
        <p>Hemos recibido tu solicitud en el sistema de PQR de <strong>SHOOP</strong>. Tu petición ha sido registrada exitosamente y nuestro equipo la revisará a la brevedad.</p>
    
        <p>La respuesta será enviada al correo electrónico asociado a tu cuenta: <strong>$emausu</strong>. Te notificaremos tan pronto como tengamos una resolución.</p>
    
        <p><strong>Importante:</strong> Si no has realizado esta solicitud, por favor ignora este mensaje. Para cualquier inquietud sobre la seguridad de tu cuenta en SHOOP, contáctanos a través de <a href='mailto:toshoop2024@gmail.com'>toshoop2024@gmail.com</a>.</p>
    
        <p>Gracias,<br>El equipo de SHOOP</p>

    </div>
    </div>
    </body>
    </html>";
            $mail->send();
        } catch (Exception $e) {
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            echo "No se a registrado tu PQR, vuelve a intentarlo";
        }
        echo "<h5>PQR radicado correctamente.</h5>";
        echo "<p>Le enviamos un mensaje de confirmación al correo $emausu</p>";
        echo "<p>Gracias por preferirnos</p>";
    }
    ?>
        <script>
            setTimeout(function () {
                <?php if (isset($_SESSION['idusu'])) { ?>
                    window.location.href = "../home.php?pg=8";
                <?php } else { ?>
                    window.location.href = "../index.php?pg=8";
                <?php } ?>
            }, 5000); // Redirecciona en 5 segundos
        </script>
        <?php
}

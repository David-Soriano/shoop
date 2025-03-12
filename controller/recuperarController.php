<?php
require_once '../model/conexion.php';
require_once '../model/musu.php';
require_once '../config/config.php'; // Configuración de correo
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Asegúrate de instalar PHPMailer con Composer

$model = new Conexion();
$db = $model->getConexion();

// Si se recibe la solicitud POST para cambiar la contraseña
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['token']) && isset($_POST['contrasena'])) {
    
    // Obtener los datos del formulario
    $token = $_POST['token'];
    $contrasena = $_POST['contrasena'];

    // Validar la contraseña
    if (strlen($contrasena) < 6) {
        echo json_encode(['success' => false, 'message' => 'La contraseña debe tener al menos 6 caracteres.']);
        exit;
    }

    // Verificar el token en la base de datos
    $query = "SELECT idusu FROM usuario WHERE token_recuperacion = :token AND token_expira > NOW()";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':token', $token, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        $idUsuario = $usuario['idusu'];
        
        // Encriptar la contraseña
        $hashedPassword = password_hash($contrasena, PASSWORD_BCRYPT);
        
        // Actualizar la contraseña en la base de datos y limpiar el token
        $query = "UPDATE usuario SET pasusu = :contrasena, token_recuperacion = NULL, token_expira = NULL WHERE idusu = :idUsuario";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':contrasena', $hashedPassword, PDO::PARAM_STR);
        $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Contraseña actualizada con éxito.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al actualizar la contraseña.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Token inválido o expirado.']);
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['correo'])) {
    $correo = trim($_POST['correo']);
    $usuarioModel = new Musu();
    $usuario = $usuarioModel->verificarCorreo($correo);

    if ($usuario) {
        $token = bin2hex(random_bytes(50));
        $idUsuario = $usuario['idusu'];
        $nomusu = $usuario['nomusu'];

        $sql = "UPDATE usuario SET token_recuperacion = :token, token_expira = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE idusu = :idUsuario";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':token', $token, PDO::PARAM_STR);
        $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);

        if ($stmt->execute()) {
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
                $mail->setFrom(MAIL_USER, MAIL_FROM_NAME);
                $mail->addAddress($correo);
                $mail->isHTML(true);
                $mail->Subject = 'Recuperación de Contraseña';
                $mail->Body = "
    <html>
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
        <div class ='email-wrapper'>
            <div class ='email-container'>
                <h1>¡Hola, $nomusu!</h1>
                <p>Hemos recibido una solicitud para restablecer la contraseña asociada con tu cuenta de SHOOP <strong>$correo</strong>.</p>
                <p>Para confirmar esta solicitud y asignar una nueva contraseña haz clic en el botón a continuación:</p>
                <form action='http://localhost/shoop/views/vwCamCont.php' method='POST'>
                    <input type='hidden' name='token' value='$token'>
                    <button class='btn' type='submit' style='background:#3CB179;color:white;padding:10px;border:none;'>Restablecer Contraseña</button>
                </form>
                <p><strong>Importante:</strong> Si no reconoces esta solicitud, te recomendamos verificar la seguridad de tu cuenta de correo electrónico de inmediato.<br> Para cualquier inquietud sobre la seguridad de tu cuenta SHOOP, no dudes en contactarnos a través de <a href='mailto:toshoop2024@gmail.com'>toshoop2024@gmail.com</a>.</p>
                <p>Gracias,<br>El equipo de SHOOP</p>
            </div>
        </div>
    </body>
    </html>
";
                $mail->send();
                echo json_encode(['success' => true, 'message' => 'Correo enviado con éxito.']);
            } catch (Exception $e) {
                error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
                echo json_encode(['success' => false, 'message' => 'Error al enviar el correo.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al guardar el token en la base de datos.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'El correo no está registrado.']);
    }
}
?>

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
                $mail->setFrom(MAIL_USER, 'Soporte');
                $mail->addAddress($correo);
                $mail->isHTML(true);
                $mail->Subject = 'Recuperación de Contraseña';
                $mail->Body = "
    <html>
    <body>
        <h1>¡Hola, $nomusu!</h1>
        <p>Para restablecer tu contraseña, usa el siguiente enlace:</p>
        <form action='http://localhost/shoop/views/vwCamCont.php' method='POST'>
            <input type='hidden' name='token' value='$token'>
            <button type='submit' style='background:#3CB179;color:white;padding:10px;border:none;'>Restablecer Contraseña</button>
        </form>
        <p>Si no puedes hacer clic en el botón, copia y pega este enlace en tu navegador:</p>
        <p>http://localhost/shoop/views/vwCamCont.php</p>
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

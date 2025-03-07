<?php include_once('../model/musu.php');
if (!class_exists('Conexion')) {
    include_once('../model/conexion.php');
}
require_once "../config/config.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';

$idusu = isset($_REQUEST['idusu']) ? $_REQUEST['idusu'] : NULL;
$nomusu = isset($_POST['nomusu']) ? $_POST['nomusu'] : NULL;
$apeusu = isset($_POST['apeusu']) ? $_POST['apeusu'] : NULL;
$tipdoc = isset($_POST['tipdoc']) ? $_POST['tipdoc'] : NULL;
$docusu = isset($_POST['docusu']) ? $_POST['docusu'] : NULL;
$emausu = isset($_POST['emausu']) ? $_POST['emausu'] : NULL;
$celusu = isset($_POST['celusu']) ? $_POST['celusu'] : NULL;
$genusu = isset($_POST['genusu']) ? $_POST['genusu'] : NULL;
$idubi = isset($_POST['ciudad']) ? $_POST['ciudad'] : NULL;
$dirrecusu = isset($_POST['dirrecusu']) ? $_POST['dirrecusu'] : NULL;
$idpef = isset($_POST['idpef']) ? $_POST['idpef'] : NULL;
$pasusu = isset($_POST['pasusu']) ? $_POST['pasusu'] : NULL;

$ope = isset($_REQUEST['ope']) ? $_REQUEST['ope'] : NULL;
$vrf = isset($_REQUEST['vrf']) ? $_REQUEST['vrf'] : NULL;
$usu = new Musu();


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$idubiUsuario = $_SESSION['idubi'] ?? null; // Ciudad del usuario

function obtenerUbicacion($idubi)
{
    // Conexión a la BD
    $modelo = new Conexion();
    $conexion = $modelo->getConexion();

    // Obtener el departamento correspondiente a la ciudad
    $stmt = $conexion->prepare("SELECT depenubi FROM ubicacion WHERE idubi = :idubi");
    $stmt->bindParam(':idubi', $idubi, PDO::PARAM_INT);
    $stmt->execute();
    $departamentoID = $stmt->fetchColumn();

    // Si `depenubi` es 0, significa que `idubi` ya es un departamento
    if ($departamentoID == 0) {
        $departamentoID = $idubi;
    }

    // Obtener todos los departamentos (depenubi = 0)
    $stmt = $conexion->prepare("SELECT * FROM ubicacion WHERE depenubi = 0");
    $stmt->execute();
    $dtDtp = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Obtener ciudades del departamento correspondiente
    $stmt = $conexion->prepare("SELECT * FROM ubicacion WHERE depenubi = :departamentoID");
    $stmt->bindParam(':departamentoID', $departamentoID, PDO::PARAM_INT);
    $stmt->execute();
    $ciudades = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return [
        'departamentoID' => $departamentoID,
        'dtDtp' => $dtDtp,
        'ciudades' => $ciudades
    ];
}

// Ejemplo de uso:

$ubicacion = obtenerUbicacion($idubiUsuario);

// Ahora puedes acceder a los datos retornados
$departamentoID = $ubicacion['departamentoID'];
$dtDtp = $ubicacion['dtDtp'];
$ciudades = $ubicacion['ciudades'];


if ($ope == "save") {
    // $recaptchaResponse = $_POST["g-recaptcha-response"]; // Capturar la respuesta de reCAPTCHA

    // if (empty($recaptchaResponse)) {
    //     echo "Error: Debe completar el reCAPTCHA.";
    //     exit();
    // }

    // // Clave secreta de Google reCAPTCHA
    // $secretKey = "6Ldez-wqAAAAANQnW__8FhdjVEwTIeVfwagEIDNnY";
    // $url = "https://www.google.com/recaptcha/api/siteverify";

    // // Datos para enviar a la API de Google
    // $data = [
    //     "secret" => $secretKey,
    //     "response" => $recaptchaResponse,
    //     "remoteip" => $_SERVER["REMOTE_ADDR"]
    // ];

    // // Hacer la solicitud a Google
    // $options = [
    //     "http" => [
    //         "header" => "Content-type: application/x-www-form-urlencoded",
    //         "method" => "POST",
    //         "content" => http_build_query($data)
    //     ]
    // ];
    // $context = stream_context_create($options);
    // $result = file_get_contents($url, false, $context);
    // $responseData = json_decode($result, true);

    // if (!$responseData["success"]) {
    //     echo "Error: reCAPTCHA no válido.";
    //     exit();
    // }

    // Si el reCAPTCHA es válido, continuar con el registro
    if ($isCorreo) {
        echo "El usuario ya se ha registrado anteriormente. Intente de nuevo";
    } else if($vrf == 1) {
        echo "Hola";
        $usu->setNomusu($nomusu);
        $usu->setApeusu($apeusu);
        $usu->setTipdoc($tipdoc);
        $usu->setDocusu($docusu);
        $usu->setEmausu($emausu);
        $usu->setCelusu($celusu);
        $usu->setGenusu($genusu);
        $usu->setIdubi($idubi);
        $usu->setDirrecusu($dirrecusu);
        $usu->setIdpef($idpef);
        $hashedPassword = password_hash($pasusu, PASSWORD_DEFAULT); // Hashear la contraseña
        $usu->setPasusu($hashedPassword);

        $res = $usu->saveUsu();
        if ($res == 2) {
            header("Location: ../views/admin.php?pg=31&error=4");
            exit();
        }

        // Si no es 2, redirige a la misma página
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else{
        $body = "<html>
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
                <p>Hemos recibido una solicitud para registrarte en nuestra plataforma. Para ingresar debes verificar el correo electrónico <strong>$emausu</strong>.</p>
                <p>Para ingresar da click en el siguiente botón para comprobar su correo electrónico y continuar con el registro:</p>
                <a href='http://localhost/shoop/controller/cusu.php?ope=save&vrf=1' class='btn'>Verificar Correo</a>

                <p>Si no puedes confirmar haciendo click en el botón de arriba, copia el siguiente enlace en la barra de direcciones de tu navegador:</p>
                <p class='link'>
                    <a href='http://localhost/shoop/controller/cusu.php?ope=save&vrf=1'>
                        http://localhost/shoop/controller/cusu.php?ope=save&vrf=1
                    </a>
                </p>

                <p><strong>Importante:</strong> Si no reconoces esta solicitud, te recomendamos verificar la seguridad de tu cuenta de correo electrónico de inmediato. Para cualquier inquietud sobre la seguridad de tu cuenta SHOOP, no dudes en contactarnos a través de <a href='mailto:toshoop2024@SHOOP.io'>toshoop2024@gmail.com</a>.</p>

                <p>Gracias,<br>El equipo de SHOOP</p>
            </div>
        </div>
    </body>
    </html>";
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
        $mail->addAddress($emausu);
        $mail->addReplyTo(MAIL_USER, 'Equipo SHOOP');

        $mail->isHTML(true);
        $mail->Subject = "Verificación de Correo";
        $mail->Body = $body;
        if($mail->send()){
            header("Location: ../views/vwConfCorr.php");
            exit;
        } else{
            echo "No fue posible enviar el correo";
        }
    } catch (\Exception $e) {
        error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
    }
    }
} else if ($ope == 'eliUs') {
    header("Content-Type: application/json");
    $usu->setIdusu($idusu);

    if ($usu->delUsu()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => "No se pudo eliminar usuario"]);
    }
} else if ($ope == 'edit') {
    $usu->setIdusu($idusu);
    $usu->setNomusu($nomusu);
    $usu->setApeusu($apeusu);
    $usu->setEmausu($emausu);
    $usu->setCelusu($celusu);
    if ($usu->editUsu()) {
        updateSession();
        header("Location: ../home.php?pg=15&msj=1");
    } else {
        header("Location: ../home.php?pg=15&msj=2");
    }
} else if ($ope == 'editPass') {
    session_start();
    $modelo = new Conexion();
    $conexion = $modelo->getConexion();

    // Obtener la contraseña actual del usuario
    $stmt = $conexion->prepare("SELECT pasusu FROM usuario WHERE idusu = :idusu");
    $stmt->bindParam(':idusu', $_SESSION['idusu'], PDO::PARAM_INT);
    $stmt->execute();
    $pass = $stmt->fetchColumn(); // Obtiene la contraseña almacenada en la BD

    // Validar que la contraseña ingresada (pasusu2) coincide con la guardada
    if (isset($_POST['pasusu2']) && password_verify($_POST['pasusu2'], $pass)) {
        $usu->setIdusu($_SESSION['idusu']);

        // Hashear la nueva contraseña ingresada
        $hashedPassword = password_hash($_POST['pasusu'], PASSWORD_DEFAULT);
        $usu->setPasusu($hashedPassword);

        // Llamar la función que actualiza la contraseña en la BD
        if ($usu->editContraseña()) {
            header("Location: ../home.php?pg=15&msj=1"); // Contraseña cambiada con éxito
        } else {
            header("Location: ../home.php?pg=15&msj=2"); // Error al actualizar
        }
    } else {
        header("Location: ../home.php?pg=15&msj=3"); // Contraseña actual incorrecta
    }

} else if ($ope == "editDir") {
    $idubi = intval($_POST['ciudad'] ?? 0);
    $usu->setIdusu($_SESSION['idusu']);
    $usu->setDirrecusu($dirrecusu);
    $usu->setIdubi($idubi);

    if ($usu->editDireccion()) {
        updateSession();
        header("Location: ../home.php?pg=15&msj=1");
    } else {
        header("Location: ../home.php?pg=15&msj=2");
    }
} else if ($ope == "inactivar") {
    $usu->setIdusu($idusu);
    if ($usu->inactivarUsu()) {
        session_destroy();
        header("Location: ../index.php");
        exit();
    } else {
        header("Location: ../home.php?pg=15&msj=2");
    }
} else if ($ope == "activar") {
    $usu->setIdusu($idusu);
    if ($usu->activarUsu()) {
        header("Location: ../home.php?pg=15&msj=1");
    } else {
        header("Location: ../home.php?pg=15&msj=2");
    }
}

function updateSession()
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $modelo = new Conexion();
    $conexion = $modelo->getConexion();
    $stmt = $conexion->prepare("SELECT 
            u.idusu, u.nomusu, u.apeusu, u.docusu, u.emausu, u.pasusu, 
            u.celusu, u.genusu, u.dirrecusu, u.tipdoc, u.fotpef, u.idpef, 
            u.idubi, u.estusu, p.nompef, p.pagini, 
            ciu.nomubi AS ciudad, dep.nomubi AS departamento 
            FROM usuario AS u 
            INNER JOIN perfil AS p ON u.idpef = p.idpef 
            INNER JOIN ubicacion AS ciu ON u.idubi = ciu.idubi 
            LEFT JOIN ubicacion AS dep ON ciu.depenubi = dep.idubi 
            WHERE u.idusu = :idusu");

    $stmt->bindParam(':idusu', $_SESSION['idusu'], PDO::PARAM_INT);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // Actualizar sesión con los datos más recientes
    if ($usuario) {
        foreach ($usuario as $key => $value) {
            $_SESSION[$key] = $value;
        }
    }
}
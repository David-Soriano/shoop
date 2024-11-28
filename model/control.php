<?php
require_once("conexion.php");

$usu = isset($_POST['user']) ? $_POST['user'] : NULL;
$pass = isset($_POST['pass']) ? $_POST['pass'] : NULL;

if ($usu && $pass) {
    valida($usu, $pass);
} else {
    red();
}

function valida($usu, $psw)
{
    $res = ingr($usu, $psw);
    $res = isset($res) ? $res : NULL;

    if ($res) {
        ini_set('session.cookie_httponly', 1);  // Evita que JavaScript acceda a las cookies
        ini_set('session.cookie_secure', 1);    // Solo permite el envío de cookies a través de HTTPS
        ini_set('session.cookie_samesite', 'Strict');
        session_start();

        $_SESSION['idusu'] = $res[0]['idusu'];
        $_SESSION['nomusu'] = $res[0]['nomusu'];
        $_SESSION['apeusu'] = $res[0]['apeusu'];
        $_SESSION['docusu'] = $res[0]['docusu'];
        $_SESSION['emausu'] = $res[0]['emausu'];
        $_SESSION['celusu'] = $res[0]['celusu'];
        $_SESSION['genusu'] = $res[0]['genusu'];
        $_SESSION['dirrecusu'] = $res[0]['dirrecusu'];
        $_SESSION['tipdoc'] = $res[0]['tipdoc'];
        $_SESSION['fotpef'] = $res[0]['fotpef'];
        $_SESSION['nompef'] = $res[0]['nompef'];
        $_SESSION['idpef'] = $res[0]['idpef'];
        $_SESSION['pagini'] = $res[0]['pagiini'];

        $_SESSION['aut'] = getenv('DB_KEY') ?: 'Msjh$5%khdfHSÑjsdh:-.';

        if ($_SESSION['idpef'] === 2) {
            header("Location: ../views/admin.php");
            exit;
        } else {
            header("Location: ../home.php");
            exit();
        }
    } else {
        red();
    }
}


function red()
{
    header("Location: ../views/vwLogin.php?err=Ok");
}


function ingr($usu, $pass)
{
    $res = NULL;

    // Query para obtener los datos del usuario basándose en su correo electrónico
    $sql = "SELECT u.idusu, u.nomusu, u.apeusu, u.docusu, u.emausu, u.pasusu, u.celusu, u.genusu, u.dirrecusu, u.tipdoc, u.fotpef, u.idpef, p.nompef, p.pagini FROM usuario AS u INNER JOIN perfil AS p ON u.idpef = p.idpef WHERE u.emausu = :emausu";

    $modelo = new Conexion();
    $conexion = $modelo->getConexion();
    $result = $conexion->prepare($sql);
    $result->bindParam(":emausu", $usu);
    $result->execute();
    $user = $result->fetch(PDO::FETCH_ASSOC);
    // Verifica si el usuario existe y si la contraseña es correcta
    if ($user && password_verify($pass, $user['pasusu'])) {
        $res = [$user];
    }
    return $res;
}


function hash_password($pass)
{
    return password_hash($pass, PASSWORD_BCRYPT);
}

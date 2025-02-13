<?php
require_once("conexion.php");

$usu = isset($_POST['user']) ? $_POST['user'] : NULL;
$pass = isset($_POST['pass']) ? $_POST['pass'] : NULL;

if ($usu && $pass) {
    valida($usu, $pass);
} else {
    red("empty");
}

function valida($usu, $psw)
{
    $user = obtenerUsuario($usu);

    if (!$user) {
        red("email"); // Error por correo incorrecto
    } elseif ($user['estusu'] === "Inactivo") {
        red("inactivo"); // Usuario inactivo
    } elseif (!password_verify($psw, $user['pasusu'])) {
        red("password"); // Error por contraseña incorrecta
    } else {
        ini_set('session.cookie_httponly', 1);
        ini_set('session.cookie_secure', 1);
        ini_set('session.cookie_samesite', 'Strict');
        session_start();

        $_SESSION['idusu'] = $user['idusu'];
        $_SESSION['nomusu'] = $user['nomusu'];
        $_SESSION['apeusu'] = $user['apeusu'];
        $_SESSION['docusu'] = $user['docusu'];
        $_SESSION['emausu'] = $user['emausu'];
        $_SESSION['celusu'] = $user['celusu'];
        $_SESSION['genusu'] = $user['genusu'];
        $_SESSION['dirrecusu'] = $user['dirrecusu'];
        $_SESSION['tipdoc'] = $user['tipdoc'];
        $_SESSION['fotpef'] = $user['fotpef'];
        $_SESSION['nompef'] = $user['nompef'];
        $_SESSION['idpef'] = $user['idpef'];
        $_SESSION['idubi'] = $user['idubi'];
        $_SESSION['departamento'] = $user['departamento'];
        $_SESSION['ciudad'] = $user['ciudad'];
        $_SESSION['pagini'] = $user['pagiini'];

        $_SESSION['aut'] = getenv('DB_KEY') ?: 'Msjh$5%khdfHSÑjsdh:-.';

        if ($_SESSION['idpef'] === 2) {
            header("Location: ../views/admin.php");
            exit;
        } else {
            header("Location: ../home.php");
            exit();
        }
    }
}

function red($error)
{
    header("Location: ../views/vwLogin.php?err=$error");
    exit();
}

function obtenerUsuario($usu)
{
    $sql = "SELECT u.idusu, u.nomusu, u.apeusu, u.docusu, u.emausu, u.pasusu, u.celusu, u.genusu, u.dirrecusu, u.tipdoc, u.fotpef, u.idpef, u.idubi, u.estusu, p.nompef, p.pagini, ciu.nomubi AS ciudad, dep.nomubi AS departamento FROM usuario AS u INNER JOIN perfil AS p ON u.idpef = p.idpef INNER JOIN ubicacion AS ciu ON u.idubi = ciu.idubi LEFT JOIN ubicacion AS dep ON ciu.depenubi = dep.idubi WHERE u.emausu = :emausu";

    $modelo = new Conexion();
    $conexion = $modelo->getConexion();
    $result = $conexion->prepare($sql);
    $result->bindParam(":emausu", $usu);
    $result->execute();
    return $result->fetch(PDO::FETCH_ASSOC);
}

function hash_password($pass)
{
    return password_hash($pass, PASSWORD_BCRYPT);
}

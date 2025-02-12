<?php include_once('../model/musu.php');
include_once('../model/conexion.php');

$nomusu = isset($_POST['nomusu']) ? $_POST['nomusu'] : NULL;
$apeusu = isset($_POST['apeusu']) ? $_POST['apeusu'] : NULL;
$tipdoc = isset($_POST['tipdoc']) ? $_POST['tipdoc'] : NULL;
$docusu = isset($_POST['docusu']) ? $_POST['docusu'] : NULL;
$emausu = isset($_POST['emausu']) ? $_POST['emausu'] : NULL;
$celusu = isset($_POST['celusu']) ? $_POST['celusu'] : NULL;
$genusu = isset($_POST['genusu']) ? $_POST['genusu'] : NULL;
$idubi = isset($_POST['ciudad']) ? $_POST['ciudad'] : NULL;
$dirrecusu = isset($_POST['dirrecusu']) ? $_POST['dirrecusu']: NULL;
$idpef = isset($_POST['idpef']) ? $_POST['idpef'] : NULL;
$pasusu = isset($_POST['pasusu']) ? $_POST['pasusu'] : NULL;

$ope = isset($_POST['ope']) ? $_POST['ope'] : NULL;

$usu = new Musu();
if ($ope == "save") {
    if ($isCorreo) {
        echo "El usuario ya se ha registrado anteriormente. Intente de nuevo";
    } else {
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
        
        $res = $usu->saveUsu(); // Aquí se recibe el idpef

        var_dump($res); // Para depuración, puedes eliminar esto después

        if ($res == 2) {
            header("Location: ../views/admin.php?pg=31");
            exit(); // Detiene la ejecución después de la redirección
        }

        // Si no es 2, redirige a la misma página
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

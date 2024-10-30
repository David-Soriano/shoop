<?php include('../model/musu.php');

$nomusu = isset($_POST['nomusu']) ? $_POST['nomusu'] : NULL;
$apeusu = isset($_POST['apeusu']) ? $_POST['apeusu'] : NULL;
$tipdoc = isset($_POST['tipdoc']) ? $_POST['tipdoc'] : NULL;
$docusu = isset($_POST['docusu']) ? $_POST['docusu'] : NULL;
$emausu = isset($_POST['emausu']) ? $_POST['emausu'] : NULL;
$celusu = isset($_POST['celusu']) ? $_POST['celusu'] : NULL;
$genusu = isset($_POST['genusu']) ? $_POST['genusu'] : NULL;
$idpef = isset($_POST['idpef']) ? $_POST['idpef'] : NULL;
$pasusu = isset($_POST['pasusu']) ? $_POST['pasusu'] : NULL;
$ope = isset($_POST['ope']) ? $_POST['ope'] : NULL;
$usu = new Musu();
$isCorreo = $usu->verificarCorreo($emausu);
if ($ope == "save") {
    if ($isCorreo) {
        echo "El usuario ya se a registrado anteriormente. Intente de nuevo";
    } else {
        $usu->setNomusu($nomusu);
        $usu->setApeusu($apeusu);
        $usu->setTipdoc($tipdoc);
        $usu->setDocusu($docusu);
        $usu->setEmausu($emausu);
        $usu->setCelusu($celusu);
        $usu->setGenusu($genusu);
        $usu->setIdpef($idpef);
        $hashedPassword = password_hash($pasusu, PASSWORD_DEFAULT); // Hashear la contraseña
        $usu->setPasusu($hashedPassword);
        $res = $usu->saveUsu();
        if ($res)
            echo "Registro Exitoso";
        else
            echo "Error en el registro";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

}
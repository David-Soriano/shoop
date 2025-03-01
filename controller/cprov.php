<?php
error_log("Formulario enviado con POST: " . print_r($_POST, true), 3, 'C:/xampp/htdocs/SHOOP/errors/debug_log.log');
// die("Se recibió el formulario.");
require_once "../model/conexion.php";
require_once("../model/mprov.php");

ini_set('session.cookie_httponly', 1);  // Evita que JavaScript acceda a las cookies
ini_set('session.cookie_secure', 1);    // Solo permite el envío de cookies a través de HTTPS
ini_set('session.cookie_samesite', 'Strict');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$prov = new Mprov();

//Proveedor
$idusu = isset($_POST['idusu']) ? $_POST['idusu'] : null;
$idprov = isset($_POST['idprov']) ? $_POST['idprov'] : NULL;
$nomprov = isset($_POST['nomprov']) ? $_POST['nomprov'] : NULL;
$dirrecprov = isset($_POST['dirrecprov']) ? $_POST['dirrecprov'] : NULL;
$idubi = isset($_POST['idubi']) ? $_POST['idubi'] : NULL;
$url = isset($_POST['urlt']) ? $_POST['urlt'] : NULL;
$nit = isset($_POST['nit']) ? $_POST['nit'] : NULL;
$desprv = isset($_POST['desprv']) ? $_POST['desprv'] : NULL;
$oper = isset($_POST['oper']) ? $_POST['oper'] : NULL;
if ($oper == "editPrv1") {
    $prov->setIdprov($idprov);
    $prov->setNomprov($nomprov);
    $prov->setDesprv($desprv);
    
    if($prov->updateProv()){
        header("Location: ../views/vwpanpro.php?vw=36&ms=1");
    } else{
        header("Location: ../views/vwpanpro.php?vw=36&ms=2");
    }
} else if($oper == "editPrv2"){
    $prov->setIdprov($idprov);
    $prov->setUrlt($url);
    $prov->setNit($nit);
    
    if($prov->updateProvDtg()){
        header("Location: ../views/vwpanpro.php?vw=36&ms=1");
    } else{
        header("Location: ../views/vwpanpro.php?vw=36&ms=2");
    }
} else if($oper == "editPrv3"){
    $idubi = intval($_POST['ciudad'] ?? 0);
    $prov->setIdprov($idprov);
    $prov->setDirrecprov($dirrecprov);
    $prov->setIdubi($idubi);
    
    if($prov->updateProvDir()){
        header("Location: ../views/vwpanpro.php?vw=36&ms=1");
    } else{
        header("Location: ../views/vwpanpro.php?vw=36&ms=2");
    }
}else if($oper == "inactivar"){
    $prov->setIdprov($idprov);
    if($prov->inactivarPrv()){
        header("Location: ../index.php");
    } else{
        header("Location: ../views/vwpanpro.php?vw=36&ms=2");
    }
} else if($oper == "reactivar"){
    $prov->setIdusu($idusu);
    $prov->activarPrv();
    header("Location: ../views/vwpanpro.php?vw=25&isn=1");
}else {
    $prov->setNomprov($nomprov);       // Nombre del proveedor
    $prov->setDirrecprov($dirrecprov); // Dirección del proveedor
    $prov->setIdubi($idubi);           // ID de ubicación
    $prov->setUrlt($url);               // URL del proveedor
    $prov->setNit($nit);               // NIT del proveedor
    $prov->setDesprv($desprv);
    $prov->setIdusu($idusu);

    $res = $prov->saveProv();
}

if ($res) {
    $_SESSION['idprov'] = $res['idprov'];
    header("Location: ../views/vwpanpro.php");
} else {
    echo "Error al registrar el proveedor";
}

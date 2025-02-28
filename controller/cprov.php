<?php
error_log("Formulario enviado con POST: " . print_r($_POST, true), 3, 'C:/xampp/htdocs/SHOOP/errors/debug_log.log');
// die("Se recibió el formulario.");
require_once "../model/conexion.php";
require_once("../model/mprov.php");

ini_set('session.cookie_httponly', 1);  // Evita que JavaScript acceda a las cookies
ini_set('session.cookie_secure', 1);    // Solo permite el envío de cookies a través de HTTPS
ini_set('session.cookie_samesite', 'Strict'); 
if(session_status() === PHP_SESSION_NONE){
    session_start();
}

$prov = new Mprov();

//Proveedor
$idusu = isset($_POST['idusu']) ? $_POST['idusu'] : null;
$nomprov = isset($_POST['nomprov']) ? $_POST['nomprov'] : NULL;
$dirrecprov = isset($_POST['dirrecprov']) ? $_POST['dirrecprov'] : NULL;
$idubi = isset($_POST['idubi']) ? $_POST['idubi'] : NULL;
$url = isset($_POST['url']) ? $_POST['url'] : NULL;
$nit = isset($_POST['nit']) ? $_POST['nit'] : NULL;
$desprv = isset($_POST['desprv']) ? $_POST['desprv'] : NULL;
$oper = isset($_POST['oper']) ? $_POST['oper'] : NULL;

$prov->setNomprov($nomprov);       // Nombre del proveedor
$prov->setDirrecprov($dirrecprov); // Dirección del proveedor
$prov->setIdubi($idubi);           // ID de ubicación
$prov->setUrl($url);               // URL del proveedor
$prov->setNit($nit);               // NIT del proveedor
$prov->setDesprv($desprv);
$prov->setIdusu($idusu);

$res = $prov->saveProv();

if($res){
    $_SESSION['idprov'] = $res['idprov'];
     header("Location: ../views/vwpanpro.php");
} else{
    echo "Error al registrar el proveedor";
}

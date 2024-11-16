<?php
include "../model/mprov.php";
include "../controller/cpancon.php";

session_start();

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
    $_SESSION['idprov'] = $res;
    header("Location: cpancon.php");
} else{
    echo "Error al registrar el proveedor";
}

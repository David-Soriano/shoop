<?php
include_once "../model/conexion.php";
include_once "../model/mpag.php";

$idpag = isset($_POST['idpag']) ? $_POST['idpag'] : NULL;
$actpag = isset($_POST['actpag']) ? $_POST['actpag'] : NULL;
$ope = isset($_POST['ope']) ? $_POST['ope'] : NULL;

$pag = new Mpag();

if($ope == "edit"){
    $pag->setIdpag($idpag);
    $pag->setActpag($actpag);
    $pag->ediPag();
    header("Location:../views/admin.php?pg=30");
    exit();
}
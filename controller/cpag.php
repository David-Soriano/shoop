<?php
include "model/mpag.php";

$pag = new Mpag();

$idpag = isset($_REQUEST['idpag']) ? $_REQUEST['idpag'] : NULL;
$nompag = isset($_POST['nompag']) ? $_POST['nompag'] : NULL;
$rutpag = isset($_POST['rutpag']) ? $_POST['rutpag'] : NULL;
$mospag = isset($_POST['mospag']) ? $_POST['mospag'] : NULL;
$icopag = isset($_POST['icopag']) ? $_POST['icopag'] : NULL;
$ope = isset($_REQUEST['ope']) ? $_REQUEST['ope'] : NULL;

$pag->setIdpag($idpag);

function getRut($pg){
    $pag = new Mpag();
    return $pag->getOne($pg);
}
$isLoggedIn = isset($_SESSION['idusu']); // Verificar si el usuario ha iniciado sesión
$dtMenu = $pag->getMenu($isLoggedIn);

$dtAll = $pag->getAll();
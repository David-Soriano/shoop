<?php
include "../model/mpag.php";
$pag = new Mpag();

$idpag = isset($_REQUEST['idpag']) ? $_REQUEST['idpag'] : NULL;
$nompag = isset($_POST['nompag']) ? $_POST['nompag'] : NULL;
$rutpag = isset($_POST['rutpag']) ? $_POST['rutpag'] : NULL;
$mospag = isset($_POST['mospag']) ? $_POST['mospag'] : NULL;
$icopag = isset($_POST['icopag']) ? $_POST['icopag'] : NULL;

$pag->setIdpag($idpag);

function getRutPrv($vw)
{
    $pag = new Mpag();
    return $pag->getOne($vw, 1, 2);
}
<?php
include "model/mtcom.php";

$compra = new compra();


$idusu = isset($_REQUEST['idusu']) ? $_REQUEST['idusu'] : NULL;
$ope = isset($_REQUEST['ope']) ? $_REQUEST['ope'] : NULL;

$compra->setIdusu($idusu);

$dtcompra = $compra->getComPar();

if (!$dtcompra) {
    $dtcompra = [];
}
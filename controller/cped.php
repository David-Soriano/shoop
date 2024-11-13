<?php
include "model/mped.php";

$pedido = new pedido();

$idusu = isset($_REQUEST['idusu']) ? $_REQUEST['idusu'] : NULL;


$ope = isset($_REQUEST['ope']) ? $_REQUEST['ope'] : NULL;

$pedido->setIdusu($idusu);
$dtpedido = $pedido->getPedPar();

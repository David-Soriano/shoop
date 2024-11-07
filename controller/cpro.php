<?php
include "model/mpro.php";

$mpro = new Mpro();
$idpro = isset($_REQUEST['idpro']) ? $_REQUEST['idpro'] : NULL;

$mpro->setIdpro($idpro);
$productos = $mpro->getInfPar();
$dtInfPrd = $mpro->getOnePrd();
$dtCarprd = $mpro->getCarPrd();
$dtImgpro = $mpro->getImagesByProduct();

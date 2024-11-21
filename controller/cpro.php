<?php

include "model/mpro.php";

$mpro = new Mpro();
$idpro = isset($_REQUEST['idpro']) ? $_REQUEST['idpro'] : NULL;
$cg = isset($_REQUEST['cg']) ? $_REQUEST['cg'] : NULL;


$mpro->setIdpro($idpro);
$productos = $mpro->getInfPar();
$dtInfPrd = $mpro->getOnePrd();
$dtCarprd = $mpro->getCarPrd();
$dtImgpro = $mpro->getImagesByProduct($idpro);
$dtSliders = $mpro->getImagesByProduct(NULL, 1);

$productosOfertas = $mpro->getInfOfertas();
$productosMasVendidos = $mpro->getInfMasVendidos();
$productosNuevos = $mpro->getProductosNuevos();
$AllProductOferta = $mpro->getInfOfertasAll();
$AllProductVend = $mpro->getInfMasVendidosAll();
$productCatego = $mpro->getCatego($cg);

// Verificar si la cookie 'provis' está definida y, si no, inicializarla como un array vacío
$proVistos = isset($_COOKIE['provis']) ? explode(',', $_COOKIE['provis']) : [];
// Añadir el producto actual a la lista si no está ya en ella
if ($idpro && !in_array($idpro, $proVistos)) {
    $proVistos[] = $idpro;
}

// Limitar a los últimos 5 productos vistos
if (count($proVistos) > 5) {
    array_shift($proVistos); // Eliminar el producto más antiguo si excede el límite
}

// Guardar la cookie actualizada con los productos vistos
setcookie('provis', implode(',', $proVistos), time() + (86400 * 30), "/"); // La cookie dura 30 días

$productosRecientes = $mpro->getProVistos();
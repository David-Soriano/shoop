<?php

include "model/mpro.php";
include "model/mrev.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$mpro = new Mpro();

$mrev = new Mrev();

$idpro = isset($_REQUEST['idpro']) ? $_REQUEST['idpro'] : NULL;
$cg = isset($_REQUEST['cg']) ? $_REQUEST['cg'] : NULL;


$frases = [
    "Moda" => [
        "inicio" => "Sumergete en la",
        "final" => "donde cada estilo cuenta tu historia."
    ],
    "Accesorios" => [
        "inicio" => "Encuentra lo mejor en",
        "final" => "para realzar tu personalidad."
    ],
    "Hogar" => [
        "inicio" => "Transforma los espacios de tu",
        "final" => "y crea el ambiente que soñaste."
    ],
    "Tecnología" => [
        "inicio" => "Explora el mundo de la",
        "final" => "impulsando tus ideas hacia el futuro.."
    ]
];

$default_inicio = "Explora el mundo de";
$default_final = "lleno de posibilidades únicas.";

$inicio = isset($frases[$cg]) ? $frases[$cg]['inicio'] : $default_inicio;
$final = isset($frases[$cg]) ? $frases[$cg]['final'] : $default_final;

$mpro->setIdpro($idpro);
$productos = $mpro->getInfPar();
$dtInfPrd = $mpro->getOnePrd();
$dtCarprd = $mpro->getCarPrd();
$dtImgpro = $mpro->getImagesByProduct($idpro);
$dtSliders = $mpro->getImagesByProduct(NULL, 1);

$mrev->setIdusu($_SESSION['idusu'] ?? null);
$dtReview = $mrev->getOneReview();

$dtProdsSuge = $mpro->getProductosSugeridos($_SESSION['idusu'] ?? null);
$dtProdSugeCatego = $mpro->getProductosPorCategoria($idpro);

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
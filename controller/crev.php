<?php
require_once __DIR__ . "/../model/mrev.php";
if(!class_exists('Conexion')){
    require_once __DIR__ . "/../model/conexion.php";
}

$idpro = isset($_POST['idpro'])? $_POST['idpro'] : null;
$idusu = isset($_POST['idusu'])? $_POST['idusu'] : null;
$rating = isset($_POST['rating'])? $_POST['rating'] : null;
$comentario = isset($_POST['comentario'])? $_POST['comentario'] : null;

var_dump($_POST);
agregarReview($idpro, $idusu, $rating, $comentario);
function agregarReview($idpro, $idusu, $rating, $comentario) {
    $mrev = new Mrev();
    $mrev->setIdpro($idpro);
    $mrev->setIdusu($idusu);
    $mrev->setRating($rating);
    $mrev->setComentario($comentario);
    if ($mrev->agregarReview()) {
        echo "Review agregada correctamente.";
    } else {
        echo "No puedes dejar una review sin haber comprado el producto.";
    }
}

function mostrarReviews($idpro) {
    $mrev = new Mrev();
    $mrev->setIdpro($idpro);
    $reviews = $mrev->obtenerReviews();
    include "views/vwReview.php";
}
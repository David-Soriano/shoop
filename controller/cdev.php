<?php
require_once __DIR__ . "/../model/mdev.php";
require_once __DIR__ . "/../model/mped.php";
require_once __DIR__ . "/../model/conexion.php";
$idped = isset($_POST['idped']) ? $_POST['idped'] : NULL;
$idpro = isset($_POST['idpro']) ? $_POST['idpro'] : NULL;
$monto = isset($_POST['monto']) ? $_POST['monto'] : NULL;
$motivo = isset($_POST['motivo']) ? $_POST['motivo'] : NULL;

var_dump($_POST);

$mdev = new Mdev();

$mped = new Pedido();

$mdev->setIdped($idped);
$mdev->setIdpro($idpro);
$mdev->setMontoreembolso($monto);
$mdev->setMotivo($motivo);

if($mdev->saveDev()){
    $mped->setIdped($idped);
    if($mped->updatePedido("Pendiente Reembolso"))
        header('Location: ../home.php');
}
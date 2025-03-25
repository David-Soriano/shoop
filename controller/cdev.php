<?php
require_once __DIR__ . "/../model/mdev.php";
require_once __DIR__ . "/../model/mped.php";
require_once __DIR__ . "/../model/conexion.php";
$idped = isset($_POST['idped']) ? $_POST['idped'] : NULL;
$idped2 = isset($_POST['idped2']) ? $_POST['idped2'] : NULL;
$idpro = isset($_POST['idpro']) ? $_POST['idpro'] : NULL;
$monto = isset($_POST['monto']) ? $_POST['monto'] : NULL;
$motivo = isset($_POST['motivo']) ? $_POST['motivo'] : NULL;

$estado = isset($_POST['estado']) ? $_POST['estado'] : NULL;
$ope = isset($_POST['ope']) ? $_POST['ope'] : NULL;

$mdev = new Mdev();

$mped = new Pedido();

$mdev->setIdped($idped);
$mdev->setIdpro($idpro);
$mdev->setMontoreembolso($monto);
$mdev->setMotivo($motivo);

if ($ope == 'edi') {
    $mdev->setIdped($idped2);
    $mdev->setEstado($estado);
    if ($mdev->updateDev()) {
        $mped->setIdped($idped2);
        if ($mped->updatePedido($estado)) {
            header('Location:../views/vwpanpro.php?vw=39');
        } else {
            echo "Error al actualizar el pedido.";
        }
    }
} else {
    if ($mdev->saveDev()) {
        $mped->setIdped($idped);
        if ($mped->updatePedido("Pendiente Reembolso"))
            header('Location: ../home.php');
    }
}
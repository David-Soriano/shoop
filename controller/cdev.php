<?php
require_once __DIR__ . "/../model/mdev.php";
require_once __DIR__ . "/../model/mped.php";
require_once __DIR__ . "/../model/mtcom.php";
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
$model = new Conexion();
$conn = $model->getConexion();

$mdev->setIdped($idped);
$mdev->setIdpro($idpro);
$mdev->setMontoreembolso($monto);
$mdev->setMotivo($motivo);

$stmPed = $conn->prepare("SELECT pr.valorunitario, p.total, pv.idprov FROM compra c LEFT JOIN pedido p ON c.idped = p.idped LEFT JOIN detallecompra d ON c.idcom = d.idcom LEFT JOIN producto pr ON d.idpro = pr.idpro INNER JOIN prodxprov AS pxp ON pxp.idpro = pr.idpro INNER JOIN proveedor AS pv ON pv.idprov = pxp.idprov WHERE p.idped = ?;");
$stmPed->execute([$idped2]);
$dtPed = $stmPed->fetch(PDO::FETCH_ASSOC);

$total = floatval($dtPed['total']);
$comision = $dtPed['valorunitario'] * 0.07;
$ivaPorcentaje = 0.19;
$subtotal = $total / (1 + $ivaPorcentaje);
$iva = $dtPed['valorunitario'] * $ivaPorcentaje;

$total_sin_iva_comision = $total - $iva - $comision;

if ($ope == 'edi') {
    $mdev->setIdped($idped2);
    $mdev->setEstado($estado);
    
    if ($mdev->updateDev()) {
        $mped->setIdped($idped2);
        if ($mped->updatePedido($estado)) {
            if ($estado == 'Devuelto') {
                $stmProveedor = $conn->prepare("UPDATE proveedor SET saldo = saldo - ? WHERE idprov = ?;");
                $stmProveedor->execute([$total_sin_iva_comision, $dtPed['idprov']]);
            }
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
<?php
require_once __DIR__ . "/../model/mdev.php";
require_once __DIR__ . "/../model/mped.php";
require_once __DIR__ . "/../model/mtcom.php";
require_once __DIR__ . "/../model/conexion.php";
require_once __DIR__ . "/../config/config.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . "/../vendor/autoload.php";

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

$stmPed = $conn->prepare("SELECT pr.valorunitario, p.total, pv.idprov, u.emausu, pr.nompro, p.idped, c.idcom FROM usuario AS u INNER JOIN compra c ON u.idusu = c.idusu LEFT JOIN pedido p ON c.idped = p.idped LEFT JOIN detallecompra d ON c.idcom = d.idcom LEFT JOIN producto pr ON d.idpro = pr.idpro INNER JOIN prodxprov AS pxp ON pxp.idpro = pr.idpro INNER JOIN proveedor AS pv ON pv.idprov = pxp.idprov WHERE p.idped = ?;");
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
                $stmComis = $conn->prepare("UPDATE comisiones SET comision = 0 WHERE idcom = ?;");
                $stmComis->execute([ $dtPed['idcom']]);
                enviarCorreoDevo($dtPed['emausu'], $dtPed['nompro'], $dtPed['idped']);
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

function enviarCorreoDevo($correoDestino, $producto, $idped)
{
    $usuario = explode('@', $correoDestino)[0]; // Obtener el nombre del usuario antes del @

    $cuerpoHtml = "<!DOCTYPE html>
<html lang='es'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Reembolso Exitoso</title>
    <style>
        .container { padding: 7%; background: #f0f7f6; text-align: center; }
        main { width: 65%; margin: 0 auto; background: #fff; padding: 20px; border-radius: 6px; border: 1px solid #e5e5e5; }
        table { border-collapse: collapse; width: 100%; }
        .header img { width: 45%; }
        .footer { padding: 5% 0; color: gray; }
    </style>
</head>

<body>
    <div class='container'>
        <main>
            <!-- Encabezado -->
            <table role='presentation' width='100%'>
                <tr>
                    <td align='left'>
                        <img src='https://shoop.ct.ws/IMG/Logo_Fijo.png' alt='Shoop, Inc' style='width: 25%; display: block;'>
                    </td>
                    <td align='right' style='font-size: 14px; font-weight: 400;'>$usuario</td>
                </tr>
            </table>

            <!-- Mensaje de Reembolso -->
            <table role='presentation' width='100%' style='display: block; background: #FFF; border-radius: 5px; padding: 4% 2%; border-left: 4px solid rgb(34, 193, 195); margin: 3% 0;'>
                <tr>
                    <td style='font-size: 17px; color: #1a1a1a; text-align: justify;'>
                        <p style='margin: 0 0 14px 0;'><b>Reembolso Aprobado</b></p>
                        <p>Estimado $usuario,</p>
                        <p>Nos complace informarte que tu solicitud de reembolso para el pedido <b># $idped</b> con el producto <b>$producto</b> ha sido resuelta con éxito.</p>
                        <p>El dinero será reembolsado a la cuenta con la cual realizaste el pago en los próximos días.</p>
                        <p>Si tienes alguna pregunta o inquietud, no dudes en contactarnos.</p>
                    </td>
                </tr>
            </table>

            <!-- Pie de página -->
            <div class='footer' style='text-align: justify;'>
                <p>Gracias por confiar en SHOOP.</p>
                <p>&copy; 2025 SHOOP, Inc.</p>
            </div>
        </main>
    </div>
</body>

</html>";

    $asunto = "Reembolso Exitoso - Pedido #$idped";
    enviarCorreo($correoDestino, $asunto, $cuerpoHtml);
}
function enviarCorreo($correoDestino, $asunto, $cuerpoHtml, $copiaOculta = null)
{
    $mail = new PHPMailer(true);
    $mail->CharSet = 'UTF-8';

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = MAIL_USER;
        $mail->Password = MAIL_PASS;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom(MAIL_USER, 'Soporte SHOOP');
        $mail->addAddress($correoDestino);
        $mail->addReplyTo(MAIL_USER, 'Equipo SHOOP');

        if ($copiaOculta) {
            $mail->addBCC($copiaOculta);
        }

        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body = $cuerpoHtml;

        $mail->send();
    } catch (\Exception $e) {
        error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
    }
}

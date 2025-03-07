<?php error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
ini_set('display_errors', 1);
include_once __DIR__ . '/../model/mped.php';
include_once __DIR__ . '/../model/mpro.php';
include_once __DIR__ . '/../model/mtcom.php';
require_once __DIR__ . "/../config/config.php";

include_once(__DIR__ . '/../model/conexion.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . "/../vendor/autoload.php";

session_start();
$idusu = isset($_REQUEST['idusu']) ? intval($_REQUEST['idusu']) : NULL;
$ope = isset($_REQUEST['ope']) ? $_REQUEST['ope'] : NULL;
$idpedido = isset($_REQUEST['idped2']) ? intval($_REQUEST['idped2']) : NULL;
$estadop = isset($_REQUEST['estped']) ? $_REQUEST['estped'] : NULL;

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['estped'])) {
    $estadoPedido = $data['estped'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json'); // Asegurar respuesta JSON

    // Leer y decodificar JSON
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    if (isset($data['idped']) && isset($data['ope'])) {
        $idped = intval($data['idped']); // Convertir a entero por seguridad
        $ope = $data['ope']; // Obtener la operación

        $pedido = new Pedido();
        $pedido->setIdped($idped);
        $dtDtosUser = $pedido->getDatosUsuario();
        // Aquí podemos usar un switch o un if para manejar las diferentes operaciones
        switch ($ope) {
            case 'cancelar':
                $resultado = $pedido->updatePedido("Cancelado");
                break;
            case 'recibir':
                $resultado = $pedido->updatePedido("Recibido");

                if ($resultado) {
                    try {
                       enviarCorreoEstadoPedido($dtDtosUser['emausu'], 'Recibido', $dtDtosUser['nompro'], $dtDtosUser['dirrecusu'], $dtDtosUser['celusu'], $dtDtosUser['imgpro']);  
                        // Obtener los datos del pedido y compra
                        $pedidoData = $pedido->getOne(); // Datos del pedido
                        $compra = new Compra();
                        $compra->setIdped($idped);

                        // Calcular el total, comisiones, IVA, etc., si es necesario
                        $total = floatval($pedidoData['total']);
                        $comision = $pedidoData['valorunitario'] * 0.07;
                        $ivaPorcentaje = 0.19;
                        $subtotal = $total / (1 + $ivaPorcentaje);
                        $iva = $pedidoData['valorunitario'] * $ivaPorcentaje;

                        // Actualizar saldo del proveedor (esto depende de la lógica de tu aplicación)
                        $modelo = new Conexion();
                        $conn = $modelo->getConexion();
                        $total_sin_iva_comision = $total - $iva - $comision;


                        $stmProveedor = $conn->prepare("UPDATE proveedor SET saldo = saldo + ? WHERE idprov = ?");
                        $stmProveedor->execute([$total_sin_iva_comision, $data['idprov']]);

                        // Guardar los datos de la compra
                        $compra->setTiproduct($pedidoData['nomval']);
                        $compra->setCantidad($pedidoData['cantidad']);
                        $compra->setPreciocom($total);
                        $compra->setTotal($total);
                        $compra->setIdpro($pedidoData['idpro']);
                        $compra->setSubtotal($subtotal);
                        $compra->setIva($iva);
                        $compra->setIdubi($pedidoData['idubi'] ?? null);
                        $compra->setIdusu($pedidoData['idusu']);
                        $compra->setDireccomp($pedidoData['direccion'] ?? "");

                        // Guardar la compra
                        $idcom = $compra->saveCompra();
                        $compra->setIdcom($idcom);

                        // Guardar los detalles de la compra
                        $compra->saveDetalleCompra();

                        $stmComisión = $conn->prepare("INSERT INTO comisiones( idcom, monto_total, comision) VALUES (?,?,?)");
                        $stmComisión->execute([$idcom, $pedidoData['valorunitario'], $comision]);

                        // Actualizar cantidad vendida
                        $idpro = $pedidoData['idpro'];
                        $cantidadVendida = $pedidoData['cantidad'];

                        $producto = new Mpro();
                        $producto->actualizarCantidadVendida($idpro, $cantidadVendida);
                    } catch (PDOException $e) {
                        error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
                        echo json_encode(['success' => false, 'error' => 'Error al guardar la compra.']);
                    }
                }
                break;
            default:
                $resultado = false;
                break;
        }

        if ($resultado) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'No se pudo actualizar el pedido.']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'ID de pedido o operación no recibidos.']);
    }

}

// Verificar que los valores necesarios están disponibles
if ($idpedido || $idusu) {
    $pedido = new pedido();
    $compra = new Compra();
    file_put_contents('C:/xampp\htdocs/SHOOP/errors/debug_log.log', "Id Pedido: " . print_r($idpedido, true) . "\n", FILE_APPEND);
    file_put_contents('C:/xampp\htdocs/SHOOP/errors/debug_log.log', "EStado Ped: " . print_r($estadop, true) . "\n", FILE_APPEND);
    file_put_contents('C:/xampp\htdocs/SHOOP/errors/debug_log.log', "Operación: " . print_r($ope, true) . "\n", FILE_APPEND);

    $pedido->setIdped($idpedido);
    $dtOnePed = $pedido->getOne();
    $dtDtosUser = $pedido->getDatosUsuario();

    $pedido->setIdped($idpedido);
    $pedido->setIdusu($idusu);
    $pedido->setEstped($estadop);
    // Obtener datos del pedido y compra
    $dtpedido = $pedido->getPedPar();
    $dtCompras = $compra->getCompras($_SESSION['idusu']);

    // Actualizar el estado del pedido y guardar la compra
    actualizarPedidoYGuardarCompra($pedido, $estadop, $dtDtosUser['emausu'], $dtDtosUser['nompro'], $dtDtosUser['dirrecusu'], $dtDtosUser['celusu'], $dtDtosUser['imgpro']);
}



// Método para seguir el envío
function segEnv($idped)
{
    $pedido = new pedido();
    $dtSegEnv = $pedido->seguirEnvio($idped);
    return $dtSegEnv;
}

// Método para actualizar el estado del pedido y guardar la compra y su detalle
function actualizarPedidoYGuardarCompra($pedido, $estped, $correo, $nompro, $direccion, $celusu, $img)
{
    try {
        $pedido->updatePedido($estped);

        switch ($estped) {
            case 'Enviado':
                enviarCorreoEstadoPedido($correo, $estped, $nompro, $direccion, $celusu, $img);
                break;

            case 'En Reparto':
                enviarCorreoEstadoPedido($correo, $estped, $nompro, $direccion, $celusu, $img);
                break;
        }

        header('Location:../views/vwpanpro.php?vw=25');

    } catch (Exception $e) {
        error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
        echo "Error. Inténtalo más tarde.";
    }
}

function enviarCorreoEstadoPedido($correoDestino, $estado, $producto, $direccion, $telefono, $img)
{
    $usuario = explode('@', $correoDestino)[0]; // Obtener el nombre del usuario antes del @

    $cuerpoHtml = "<!DOCTYPE html>
<html lang='es'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Estado de tu Pedido</title>
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

            <!-- Estado del Pedido -->
            <table role='presentation' width='100%' style='display: block; background: #FFF; border-radius: 5px; padding: 4% 2%; border-left: 4px solid rgb(250, 78, 105); margin: 3% 0;'>
                <tr'>
                    <td width='65%' style='font-size: 17px; color: #1a1a1a; text-align: justify;'>
                        <p style='margin: 0 0 14px 0;'>$estado $producto</p>
                        <h5 style='text-align: justify; font-size: 14px; margin: 0;'>";
                        if ($estado == 'Recibido') {
                            $cuerpoHtml .= "Recibiste tu Compra";
                        } else{
                            $cuerpoHtml .= "Llegará pronto";
                        }
                        $cuerpoHtml .= "</h5>
                    </td>
                    <td width='35%'>
                        <img src='https://shoop.ct.ws/$img' alt='Producto' style='width: 100%; max-width: 150px; display: block; margin: auto;'>
                    </td>
                </tr>
            </table>

            <!-- Detalles del envío -->
            <table role='presentation' width='100%' style='display: block; padding: 3%; background: #FFF; margin-top: 4%; border-radius: 6px; border: 1px solid #e5e5e5;'>
                <tr>
                    <td style='font-size: 17px; font-weight: 400; text-align: justify;'>";
                    if ($estado == 'Enviado') {
                        $cuerpoHtml .= "El pedido fue enviado y muy pronto llegará a tu destino. Te avisaremos cuando esté cerca.";
                    } else if ($estado == 'En Reparto') {
                        $cuerpoHtml .= "Nuestro repartidor está en tu zona. Prepárate para recibir tu pedido en cualquier momento.";
                    } else if ($estado == 'Recibido') {
                        $cuerpoHtml .= "Tu pedido ha sido entregado con éxito. Esperamos que lo disfrutes.";
                    }

$cuerpoHtml .="</td>
            </tr>
                <tr>
                    <td style='font-size: 20px; margin: 0; text-align: justify;'><b>Detalles del envío:</b></td>
                </tr>
                <tr>
                    <td style='display: flex; align-items: center;'>
                        <table role='presentation' width='100%'>
                            <tr>
                                <td width='10%' style='text-align: center; font-size: 25px;'>📍</td>
                                <td width='90%' style='text-align: justify; font-size: 17px;'>
                                    <p style='font-size: 19px;'>$direccion</p>
                                    <p style='color: gray; font-size: 14px;'>Cel: $telefono</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <!-- Pie de página -->
            <div class='footer' style='text-align: justify;'>
                <p>Si tienes preguntas, responde este correo o contáctanos en nuestro soporte.</p>
                <p>&copy; 2025 SHOOP, Inc.</p>
            </div>
        </main>
    </div>
</body>

</html>";

    if($estado == "Recibido"){
        $asunto = "Hola, ¡Llegué!";
    } else{
        $asunto = "Estado del pedido";
    }
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



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

    // Depuración: Verificar si se recibe el JSON
    file_put_contents('C:/xampp\htdocs/SHOOP/errors/debug_log.log', "Recibido: " . print_r($data, true) . "\n", FILE_APPEND);

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
                        $asunto = "¡Tu pedido ha sido entregado!";
                        $cuerpoHtml = generarCorreoPedido($dtDtosUser['nomusu'], "Recibido");
                        enviarCorreo($dtDtosUser['emausu'], $asunto, $cuerpoHtml);
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
    actualizarPedidoYGuardarCompra($pedido, $estadop, $dtDtosUser['emausu'], $dtDtosUser['nompro'], $dtDtosUser['dirrecusu'], $dtDtosUser['celusu']);
}



// Método para seguir el envío
function segEnv($idped)
{
    $pedido = new pedido();
    $dtSegEnv = $pedido->seguirEnvio($idped);
    return $dtSegEnv;
}

// Método para actualizar el estado del pedido y guardar la compra y su detalle
function actualizarPedidoYGuardarCompra($pedido, $estped, $correo, $nompro, $direccion, $celusu)
{
    try {
        $pedido->updatePedido($estped);

        switch ($estped) {
            case 'Enviado':
                enviarCorreoEstadoPedido($correo, $estped, $nompro, $direccion, $celusu);
                break;

            case 'En Reparto':
                
                break;
        }

        header('Location:../views/vwpanpro.php?vw=25');

    } catch (Exception $e) {
        error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
        echo "Error. Inténtalo más tarde.";
    }
}

function enviarCorreoEstadoPedido($correoDestino, $estado, $producto, $direccion, $telefono)
{
    $usuario = explode('@', $correoDestino)[0]; // Obtener el nombre del usuario antes del @

    $cuerpoHtml = "<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Estado de tu Pedido</title>
    <style>
        .container { display: flex; justify-content: center; align-items: center; background: #f5f5f5; }
        main { width: 65%; }
        .header { padding: 5% 0; }
        .header img { width: 45%; }
        .bx-user { text-align: end; font-size: 14px; font-weight: 400; }
        .bx-ini { background: #FFF; border-radius: 5px; padding: 4% 2%; border-left: 4px solid rgb(0, 166, 80); }
        .bx-ini_inf p { font-size: 17px; color: #1a1a1a; }
        .bx-ini img { width: 40%; }
        .bx-body { padding: 3%; background: #FFF; margin-top: 4%; border-radius: 6px; border: 1px solid #e5e5e5; }
        .bx-body_ini { font-size: 17px; font-weight: 400; }
        .bx-body h6 { font-size: 20px; }
        .bx-body_dt .ico { display: flex; flex-direction: column; align-items: center; }
        .bx-body_dt .ico i { font-size: 25px; }
        .footer { padding: 5% 0; color: gray; }
    </style>
</head>
<body>
    <div class='container'>
        <main>
            <div class='header'>
                <div style='width: 50%; float: left;'>
                    <img src='https://dummyimage.com/600x200/000/fff.png&text=Prueba' alt='Shoop, Inc'>
                </div>
                <div style='width: 50%; float: right; text-align: right;' class='bx-user'>$usuario</div>
                <div style='clear: both;'></div>
            </div>
            <div class='bx-ini'>
                <div style='width: 65%; float: left;' class='bx-ini_inf'>
                    <p>$estado $producto</p>
                    <h5>Llegará pronto</h5>
                </div>
                <div style='width: 35%; float: right;'>
                    <img src='https://dummyimage.com/600x200/000/fff.png&text=Prueba' alt='producto'>
                </div>
                <div style='clear: both;'></div>
            </div>
            <div class='bx-body'>
                <p class='bx-body_ini'>El pedido fue enviado y muy pronto llegará a tu destino. Te avisaremos cuando esté cerca.</p>
                <h6>Detalles del envío:</h6>
                <div class='bx-body_dt'>
                    <div style='width: 10%; float: left; text-align: center;' class='ico'>
                        <i class='bi bi-geo-alt'></i>
                    </div>
                    <div style='width: 90%; float: left;' class='dt'>
                        <p class='dir'>$direccion</p>
                        <p class='tel'>$telefono</p>
                    </div>
                    <div style='clear: both;'></div>
                </div>
            </div>
            <div class='footer'>
                <p>Si tienes preguntas, responde este correo o contáctanos en nuestro soporte.</p>
                <p>&copy; 2025 SHOOP, Inc.</p>
            </div>
        </main>
    </div>
</body>
</html>
";

    enviarCorreo($correoDestino, 'Estado de tu pedido', $cuerpoHtml);
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



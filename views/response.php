<?php
require_once '../model/conexion.php'; // Asegúrate de conectar a la BD
require_once '../model/mcarr.php';
require_once '../model/mprov.php';
require_once "../config/config.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "../vendor/autoload.php";

session_start();

$modelo = new Conexion();
$carrito = new CarritoModel($modelo->getConexion());
$mprov = new Mprov();
$conn = $modelo->getConexion();
if (!$conn) {
    error_log("Error de conexión a la base de datos.", 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
}

$status = $_REQUEST['transactionState'] ?? '';
$idusu = $_SESSION['idusu'];
$total = $_REQUEST['TX_VALUE'] ?? 0;
$mpago = $_REQUEST['lapPaymentMethod'] ?? '';
$npago = $_REQUEST['lapPaymentMethodType'] ?? '';
$idfactura = $_REQUEST['reference_pol'];
$total = filter_var($total, FILTER_VALIDATE_FLOAT) ?: 0;

$message = ($status == 4) ? "¡Pago aprobado!" : "Hubo un problema con el pago.";

if ($status == 4 && $idusu > 0 && $total > 0) {
    try {
        $conn->beginTransaction();

        $carrito->limpiarCarrito($idusu);
        // Insertar en la tabla pedido
        $stmt = $conn->prepare("INSERT INTO pedido (idusu, total, fecha, estped) VALUES (?, ?, NOW(), 'Aprobado')");
        $stmt->execute([$idusu, $total]);

        $idPedido = $conn->lastInsertId(); // Obtener el ID del pedido insertado

        // Insertar en la tabla detalle_pedido
        $productosJson = $_REQUEST['extra1'] ?? ''; // Recibir JSON de productos
        $ubicacionJson = $_REQUEST['extra2'] ?? '';
        $productos = json_decode($productosJson, true);
        $ubicacion = json_decode($ubicacionJson, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log("Error al decodificar JSON de ubicación: " . json_last_error_msg(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
        }

        if (json_last_error() === JSON_ERROR_NONE && is_array($productos) && is_array($ubicacion)) {
            $stmtDetalle = $conn->prepare("INSERT INTO detalle_pedido (idped, idpro, cantidad, precio, mpago, npago, direccion, idubi) 
                                   VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmAccCantidad = $conn->prepare("UPDATE producto SET cantidad = cantidad - ? WHERE idpro = ?");
                                   enviarFactura($_SESSION['emausu'], $_SESSION['nomusu'], $productos, $total, $ubicacion['direccion'], $idfactura);
            foreach ($productos as $producto) {
                if (isset($producto['id'], $producto['cantidad'], $producto['precio'])) {
                    // Obtener dirección e idubi de la ubicación decodificada
                    $direccion = isset($ubicacion['direccion']) ? $ubicacion['direccion'] : '';
                    $idubi = isset($ubicacion['idubi']) ? $ubicacion['idubi'] : null;

                    // Ejecutar la consulta con los valores correspondientes
                    $stmtDetalle->execute([$idPedido, $producto['id'], $producto['cantidad'], $producto['precio'], $mpago, $npago, $direccion, $idubi]);
                    // Disminuir la cantidad en stock
                    $stmAccCantidad->execute([$producto['cantidad'], $producto['id']]);
                }
            }
            $conn->commit();
        } else {
            throw new Exception("Error al decodificar JSON de productos: " . json_last_error_msg());
        }
    } catch (Exception $e) {
        $conn->rollBack();
        error_log("Error al guardar pedido: " . $e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
        $message = "Hubo un error al registrar la compra.";
    }
}

function enviarFactura($correo, $nombreCliente, $productos, $total, $direccion, $idfactura) {
    $productosHtml = '';
    foreach ($productos as $producto) {
        $productosHtml .= "<tr>
            <td>{$producto['nombre']}</td>
            <td>{$producto['cantidad']}</td>
            <td>{$producto['precio']}</td>
        </tr>";
    }

    $cuerpoHtml = "
    <html>
    <head>
        <style>
        .invoice-box { max-width: 800px; margin: auto; padding: 30px; border: 1px solid #eee; box-shadow: 0 0 10px rgba(0, 0, 0, 0.15); font-size: 16px; font-family: 'Helvetica Neue', Arial, sans-serif; color: #555; }
        .invoice-box table { width: 100%; text-align: left; }
        .invoice-box table td { padding: 5px; vertical-align: top; }
        .invoice-box table tr.heading td { background: #eee; border-bottom: 1px solid #ddd; font-weight: bold; }
        .invoice-box table tr.item td { border-bottom: 1px solid #eee; }
        .invoice-box table tr.total td:nth-child(3) { border-top: 2px solid #eee; font-weight: bold; text-align: right; }
        .banner { text-align: center; margin-bottom: 20px; }
        .banner img { max-width: 100px; }
        </style>
    </head>
    <body>
        <div class='invoice-box'>
        <div class='banner'>
            <img src='https://dummyimage.com/600x200/000/fff.png&text=Prueba' alt='Shoop, Inc'>
        </div>
        <table>
            <tr class='top'>
                <td colspan='2'>
                    <table>
                        <tr>
                            <td><h2>Factura de Compra</h2></td>
                            <td>Fecha: " . date('d-m-Y') . "<br>Número de Factura: {$idfactura}</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class='information'>
                <td colspan='2'>
                    <table>
                        <tr><td><h4>Detalles de la Tienda</h4>SHOOP, Inc.<br>www.shoop.com<br>Chía, Colombia</td></tr>
                        <tr><td><h4>Detalles del Cliente</h4>Nombre: {$nombreCliente}<br>Correo: {$correo}<br>Dirección: {$direccion}</td></tr>
                    </table>
                </td>
            </tr>
            <tr class='heading'><td>Producto</td><td>Cantidad</td><td>Precio</td></tr>
            {$productosHtml}
            <tr class='total'><td></td><td></td><td>Total: $" . number_format($total, 2, ",", ".") . "</td></tr>
        </table>
        <br>
        <h3>Consejos y Recomendaciones</h3>
        <p>Gracias por tu compra. Te recomendamos revisar nuestros nuevos productos y ofertas especiales.</p>
        <p>Si tienes alguna pregunta, no dudes en contactarnos a través de nuestro correo de soporte.</p>
        <p>¡Esperamos verte pronto!</p>
        </div>
    </body>
    </html>";

    enviarCorreo($correo, 'Factura de Compra', $cuerpoHtml, 'toshoop2024@gmail.com');
}

function enviarCorreo($correoDestino, $asunto, $cuerpoHtml, $copiaOculta = null) {
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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estado Transacción</title>
    <link rel="stylesheet" href="../CSS/admin.css">
</head>

<body>
    <div class="container">
        <div class="row bx-pago-conf">
            <div class="col">
                <h3><?= htmlspecialchars($message) ?></h3>
                <p>Gracias Por Tu Compra</p>
            </div>
        </div>
    </div>
    <script>
        setTimeout(function() {
            window.location.href = "http://localhost/shoop/home.php?pg=17&idusu=<?= urlencode($idusu) ?>";
        }, 5000);
    </script>
</body>

</html>
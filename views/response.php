<?php
require_once '../model/conexion.php'; // Asegúrate de conectar a la BD
require_once '../model/mcarr.php';
session_start();
$modelo = new Conexion();
$carrito = new CarritoModel($modelo->getConexion());
$conn = $modelo->getConexion();
if (!$conn) {
    error_log("Error de conexión a la base de datos.", 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
}
$status = $_REQUEST['transactionState'] ?? ''; // Usa $_POST en lugar de $_REQUEST
$idusu = $_SESSION['idusu']; // ID del usuario (se mantiene con $_REQUEST)
$total = $_REQUEST['TX_VALUE'] ?? 0; // Monto total
$mpago = $_REQUEST['lapPaymentMethod'] ?? '';
$npago = $_REQUEST['lapPaymentMethodType'] ?? '';
$total = filter_var($total, FILTER_VALIDATE_FLOAT) ?: 0; // Asegurar número válido
$message = ($status == 4) ? "¡Pago aprobado!" : "Hubo un problema con el pago.";

if ($status == 4 && $idusu > 0 && $total > 0) { // Verifica valores antes de continuar
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

            foreach ($productos as $producto) {
                if (isset($producto['id'], $producto['cantidad'], $producto['precio'])) {
                    // Obtener dirección e idubi de la ubicación decodificada
                    $direccion = isset($ubicacion['direccion']) ? $ubicacion['direccion'] : '';
                    $idubi = isset($ubicacion['idubi']) ? $ubicacion['idubi'] : null;

                    // Ejecutar la consulta con los valores correspondientes
                    $stmtDetalle->execute([$idPedido, $producto['id'], $producto['cantidad'], $producto['precio'], $mpago, $npago, $direccion, $idubi]);
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

// Registrar en el log
error_log("Estado de la transacción: " . json_encode($_REQUEST));

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
        setTimeout(function () {
            window.location.href = "http://localhost/shoop/home.php?pg=17&idusu=<?= urlencode($idusu) ?>";
        }, 5000);
    </script>
</body>

</html>
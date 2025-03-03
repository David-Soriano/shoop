<?php error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
ini_set('display_errors', 1);
include_once __DIR__ . '/../model/mped.php';
include_once __DIR__ . '/../model/mpro.php';
include_once __DIR__ . '/../model/mtcom.php';

include_once(__DIR__ . '/../model/conexion.php');

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

        // Aquí podemos usar un switch o un if para manejar las diferentes operaciones
        switch ($ope) {
            case 'cancelar':
                $resultado = $pedido->updatePedido("Cancelado");
                break;
            case 'recibir':
                $resultado = $pedido->updatePedido("Recibido");

                if ($resultado) {
                    try {
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

    $pedido->setIdped($idpedido);
    $pedido->setIdusu($idusu);
    $pedido->setEstped($estadop);
    // Obtener datos del pedido y compra
    $dtpedido = $pedido->getPedPar();
    $dtCompras = $compra->getCompras($_SESSION['idusu']);

    // Actualizar el estado del pedido y guardar la compra
    actualizarPedidoYGuardarCompra($pedido, $estadop, $idpedido, $ope);
}



// Método para seguir el envío
function segEnv($idped)
{
    $pedido = new pedido();
    $dtSegEnv = $pedido->seguirEnvio($idped);
    return $dtSegEnv;
}

// Método para actualizar el estado del pedido y guardar la compra y su detalle
function actualizarPedidoYGuardarCompra($pedido, $estped, $idped, $ope)
{
    try {
        $pedido->updatePedido($estped);
        header('Location:../views/vwpanpro.php?vw=25');

    } catch (Exception $e) {
        error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
        echo "Error. Inténtalo más tarde.";
    }
}


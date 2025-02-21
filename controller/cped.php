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

    if (isset($data['idped'])) {
        $idped = intval($data['idped']); // Convertir a entero por seguridad

        $pedido = new Pedido();
        $pedido->setIdped($idped);
        $resultado = $pedido->cancelPedido();

        if ($resultado) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'No se pudo cancelar el pedido.']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'ID de pedido no recibido.']);
    }
}
// Verificar que los valores necesarios están disponibles
if ($idpedido || $idusu) {
    $pedido = new pedido();
    $compra = new Compra();

    $pedido->setIdped($idpedido);
    $dtOnePed = $pedido->getOne();

    $pedido->setIdped($idpedido);
    $pedido->setIdusu($idusu);
    $pedido->setEstped($estadop);
    // Obtener datos del pedido y compra
    $dtpedido = $pedido->getPedPar();
    $dtCompras = $compra->getCompras($_SESSION['idusu']);

    // Actualizar el estado del pedido y guardar la compra
    actualizarPedidoYGuardarCompra($pedido, $compra, $dtOnePed);
}



// Método para seguir el envío
function segEnv($idped)
{
    $pedido = new pedido();
    $dtSegEnv = $pedido->seguirEnvio($idped);
    return $dtSegEnv;
}

// Método para actualizar el estado del pedido y guardar la compra y su detalle
function actualizarPedidoYGuardarCompra($pedido, $compra, $data)
{
    try {
        // Actualizar el estado del pedido
        $estadoActualizado = $pedido->updatePedido();

        if ($estadoActualizado) {
            $estadoPedido = $pedido->getEstped();
            if ($estadoPedido === 'Recibido') {
                $modelo = new Conexion();
                $conn = $modelo->getConexion();
                $total = floatval($data['total']);
                $comision = $total * 0.07;
                $ivaPorcentaje = 0.19; // 19% de IVA

                // Calcular subtotal e IVA
                $subtotal = $total / (1 + $ivaPorcentaje);
                $iva = $total * $ivaPorcentaje;

                $total_sin_iva_comision = $total - $iva - $comision;
                $stmProveedor = $conn->prepare("UPDATE proveedor SET saldo = saldo + ? WHERE idprov = ?");
                $stmProveedor->execute([$total_sin_iva_comision, $_SESSION['idprov']]);
                // Asignar valores a los setters
                $compra->setTiproduct($data['nomval']);
                $compra->setCantidad($data['cantidad']);
                $compra->setPreciocom($total);
                $compra->setTotal($total);
                $compra->setIdpro($data['idpro']);
                $compra->setSubtotal($subtotal);
                $compra->setIva($iva);
                $compra->setIdubi($data['idubi'] ?? null); 
                $compra->setIdusu($data['idusu']);
                $compra->setIdped($data['idped']);
                $compra->setDireccomp($data['direccion'] ?? "");

                $idcom = $compra->saveCompra();
                $compra->setIdcom($idcom);

                $compra->saveDetalleCompra();

                $idpro = $data['idpro']; 
                $cantidadVendida = $data['cantidad'];

                $producto = new Mpro();  
                $producto->actualizarCantidadVendida($idpro, $cantidadVendida);
            }
        }
        header('Location:../views/vwpanpro.php?vw=25');
    } catch (Exception $e) {
        error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
        echo "Error. Inténtalo más tarde.";
    }
}


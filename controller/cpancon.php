<?php
ini_set('session.cookie_httponly', 1); // Evita que JavaScript acceda a las cookies
ini_set('session.cookie_secure', 1); // Solo permite el envío de cookies a través de HTTPS
ini_set('session.cookie_samesite', 'Strict');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../model/conexion.php';
require_once '../model/mpancon.php';
require_once '../model/mprov.php';
require_once '../model/mpro.php';
require_once '../model/mped.php';

$control = new Mpancon();
$prov = new Mprov();
$mpro = new Mpro();
$mped = new Pedido();

$idusus = $_SESSION['idusu'] ?? null;
$idProveedor = $idusus ? $prov->existeProveedor($idusus) : null;
$idpro = $_REQUEST['idpro'] ?? null;

$idusu = $_POST['idusu'] ?? null;
$nompro = $_POST['nompro'] ?? null;
$descripcion = $_POST['descripcion'] ?? null;
$cantidad = $_POST['cantidad'] ?? null;
$idval = $_POST['idval'] ?? null;
$valorunitario = $_POST['valorunitario'] ?? null;
$precio = $_POST['precio'] ?? null;
$pordescu = $_POST['pordescu'] ?? null;

$fechiniofer = $_POST['fechiniofer'] ?? null;
$fechfinofer = $_POST['fechfinofer'] ?? null;

$ope = $_REQUEST['ope'] ?? null;

// Paginación de tablas
$resultsPerPage = 10;
$currentPage = (int) ($_GET['page'] ?? 1);
$offset = ($currentPage - 1) * $resultsPerPage;

$dtCatego = $control->getCategorías();
$control->getIdPrv($idusus);

// Obtener el total de productos del proveedor
$totalResults = $idProveedor ? $mpro->getCantPrd($idProveedor) : 0;
$totalPedidos = $mped->getTotalPed();

$totalPed = ceil($totalPedidos / $resultsPerPage);
$totalPages = ceil($totalResults / $resultsPerPage);

$dtAllPrd = $mpro->getAllPrd($idProveedor, $resultsPerPage, $offset);
$dtAllPedidos = $mped->getPedidos($_SESSION['idprov']);

$saldo = $prov->traerSaldo($idProveedor);

$start = $offset + 1;
$end = min($offset + $resultsPerPage, $totalResults);
$end2 = min($offset + $resultsPerPage, $totalPedidos);

$recordsMessage = "Mostrando: <b>{$start}-{$end}</b> de <b>{$totalResults}</b> resultados";
$recordsMessage2 = "Mostrando: <b>{$start}-{$end2}</b> de <b>{$totalPedidos}</b> resultados";

$caracteristicas = $_POST['descripcioncr'] ?? [];
$res = "";

// Validar usuario y proveedor
if ($idusus) {
    if (!$idProveedor) {
        header("Location: ../views/vwRegPrv.php");
        exit();
    }

    if ($ope === 'save') {
        $pro = new Mpro();
        $pro->setNompro($nompro);
        $pro->setDescripcion($descripcion);
        $pro->setCantidad($cantidad);
        $pro->setIdval($idval);
        $pro->setValorunitario($valorunitario);
        $pro->setPordescu($pordescu);
        $pro->setPrecio($precio);
        $pro->setFechiniofer($fechiniofer);
        $pro->setFechfinofer($fechfinofer);

        $imagenesGuardadas = [];
        // echo "<pre> imagenes Recibidas";
        // print_r($_FILES['imgpro']);
        // echo "</pre>";
        $archivos_validos = array_filter($_FILES['imgpro']['name'], function ($nombre, $key) {
            return !empty($nombre) && $_FILES['imgpro']['error'][$key] === 0;
        }, ARRAY_FILTER_USE_BOTH);

        if (!empty($archivos_validos)) {
            $ruta = '../proinf';
            foreach ($_FILES['imgpro']['name'] as $key => $nombreOriginal) {
                $archivo = [
                    'name' => $_FILES['imgpro']['name'][$key],
                    'tmp_name' => $_FILES['imgpro']['tmp_name'][$key],
                    'type' => $_FILES['imgpro']['type'][$key],
                    'size' => $_FILES['imgpro']['size'][$key],
                ];
                $prefijo = uniqid();
                $nombreBase = 'imagen';
                $rutaFinal = $control->procesarImagen($archivo, $ruta, $nombreBase, $prefijo);
                // echo "<pre>Ruta Final";
                // print_r($rutaFinal);
                // echo "</pre>";
                if ($rutaFinal) {
                    $imagenesGuardadas[] = [
                        'imgpro' => $rutaFinal,
                        'nomimg' => pathinfo($nombreOriginal, PATHINFO_FILENAME),
                        'tipimg' => $archivo['type'],
                        'ordimg' => $key + 1,
                    ];
                } else {
                    echo "Error al procesar $nombreOriginal<br>";
                }
            }
        }
        // echo "<pre>Imagenes guardadas";
        // print_r($imagenesGuardadas);
        // echo "</pre>";
        // die();
        if (!empty($imagenesGuardadas)) {
            try {
                $res = $pro->saveProductoConImagenes($imagenesGuardadas, $caracteristicas);
                if ($res) {
                    // Inserta productos por proveedor antes de redirigir
                    if ($idProveedor) {
                        $prov->insertProdxProv($idProveedor, $res);
                    }
                    header("Location: ../views/vwpanpro.php?vw=23");
                    exit();
                } else {
                    echo "Error al guardar el producto.";
                }
            } catch (PDOException $e) {
                error_log($e->getMessage(), 3, '../errors/error_log.log');
                echo "Error al guardar el producto en la base de datos.";
            }
        }
    } elseif ($idpro && $ope === 'edit') {
        try {
            $mpro->setIdpro($idpro);
            $mpro->setNompro($nompro);
            $mpro->setDescripcion($descripcion);
            $mpro->setCantidad($cantidad);
            $mpro->setIdval($idval);
            $mpro->setValorunitario($valorunitario);
            $mpro->setPordescu($pordescu);
            $mpro->setPrecio($precio);
            $mpro->setFechiniofer($fechiniofer);
            $mpro->setFechfinofer($fechfinofer);

            $imagenesActualizadas = $_POST['imagenesExistentes'] ?? [];

            if (!empty($_FILES['imgpro']['name'][0])) {
                $ruta = '../proinf';
                foreach ($_FILES['imgpro']['name'] as $key => $nombreOriginal) {
                    $archivo = [
                        'name' => $_FILES['imgpro']['name'][$key],
                        'tmp_name' => $_FILES['imgpro']['tmp_name'][$key],
                        'type' => $_FILES['imgpro']['type'][$key],
                        'size' => $_FILES['imgpro']['size'][$key],
                    ];
                    $prefijo = uniqid();
                    $nombreBase = 'imagen';
                    $rutaFinal = $control->procesarImagen($archivo, $ruta, $nombreBase, $prefijo);

                    if ($rutaFinal) {
                        $imagenesActualizadas[] = [
                            'imgpro' => $rutaFinal,
                            'nomimg' => pathinfo($nombreOriginal, PATHINFO_FILENAME),
                            'tipimg' => $archivo['type'],
                            'ordimg' => $key + 1,
                        ];
                    }
                }
            }

            if (!empty($_POST['ordenImagenes'])) {
                $ordenImagenes = array_map(fn($item) => json_decode($item, true), $_POST['ordenImagenes']);
                foreach ($ordenImagenes as $orden) {
                    foreach ($imagenesActualizadas as &$imagen) {
                        if ($imagen['imgpro'] === $orden['imgpro']) {
                            $imagen['ordimg'] = $orden['ordimg'];
                            break;
                        }
                    }
                }
            }

            if (!empty($imagenesActualizadas)) {
                $mpro->updateImagenesProducto($imagenesActualizadas);
            }

            if (!empty($caracteristicas)) {
                $mpro->updateCaracteristicas($caracteristicas, $idpro);
            }

            if ($mpro->updateProducto()) {
                header("Location: ../views/vwpanpro.php?vw=001");
                exit();
            } else {
                echo "Error al actualizar el producto.";
            }
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, '../errors/error_log.log');
            echo "Error al actualizar el producto.";
        }
    }
} else {
    echo "Usuario no autenticado.";
}

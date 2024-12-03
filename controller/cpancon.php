<?php
ini_set('session.cookie_httponly', 1);  // Evita que JavaScript acceda a las cookies
ini_set('session.cookie_secure', 1);    // Solo permite el envío de cookies a través de HTTPS
ini_set('session.cookie_samesite', 'Strict'); 
session_start();
include "../model/conexion.php";
include "../model/mpancon.php";
require_once "../model/mprov.php";
include "../model/mpro.php";

$control = new Mpancon();
$prov = new Mprov();
$mpro = new Mpro();
$idusus = isset($_SESSION['idusu']) ? $_SESSION['idusu'] : null;
$idProveedor = $prov->existeProveedor($idusus);
$idpro = isset($_REQUEST['idpro']) ? $_REQUEST['idpro'] : null;

$idusu = isset($_POST['idusu']) ? $_POST['idusu'] : null;
$nompro = isset($_POST['nompro']) ? $_POST['nompro'] : NULL;
$descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : NULL;
$cantidad = isset($_POST['cantidad']) ? $_POST['cantidad'] : NULL;
$idval = isset($_POST['idval']) ? $_POST['idval'] : NULL;
$valorunitario = isset($_POST['valorunitario']) ? $_POST['valorunitario'] : NULL;
$precio = isset($_POST['precio']) ? $_POST['precio'] : NULL;
$pordescu = isset($_POST['pordescu']) ? $_POST['pordescu'] : NULL;

$fechiniofer = isset($_POST['fechiniofer']) ? $_POST['fechiniofer'] : NULL;
$fechfinofer = isset($_POST['fechfinofer']) ? $_POST['fechfinofer'] : NULL;

$ope = isset($_REQUEST['ope']) ? $_REQUEST['ope'] : NULL;
// Paginación de tablas
$resultsPerPage = 10;
$currentPage = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($currentPage - 1) * $resultsPerPage;

$dtCatego = $control->getCategorías();
$control->getIdPrv($idusus);

// Obtener el total de productos del proveedor
$totalResults = $mpro->getCantPrd($_SESSION['idprov']);

// Calcular el número total de páginas
$totalPages = ceil($totalResults / $resultsPerPage);

// Consulta para obtener productos según la búsqueda
$dtAllPrd = $mpro->getAllPrd($_SESSION['idprov'], $resultsPerPage, $offset);

// Calcular los límites para "Mostrando X-Y de Z resultados"
$start = $offset + 1;
$end = min($offset + $resultsPerPage, $totalResults);

// Generar el mensaje dinámico
$recordsMessage = "Mostrando: <b>{$start}-{$end}</b> de <b>{$totalResults}</b> resultados";


$caracteristicas = [];
if (isset($_POST['descripcioncr']) && is_array($_POST['descripcioncr'])) {
    $caracteristicas = $_POST['descripcioncr'];
}

$res = "";
// Proveedor
if ($idusu) {
    // Verificar si el proveedor existe
    if (!$prov->existeProveedor($idusus)) {
        // Redirigir al formulario de registro de proveedor si no existe
        header("Location: ../views/vwRegPrv.php");
        exit(); // Detener ejecución adicional
    } else {
        require_once '../model/mpro.php';

        //Guardar Producto

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
        if (!empty($_FILES['imgpro']['name'][0])) {
            $ruta = '../proinf';
            $imagenesGuardadas = []; // Almacenar datos para insertarlos luego
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
                    // Preparar datos para la base de datos
                    $imgpro = $rutaFinal;          // Ruta final de la imagen (se almacena en imgpro)
                    $nomimg = pathinfo($nombreOriginal, PATHINFO_FILENAME); // Nombre de la imagen sin extensión
                    $tipimg = $archivo['type'];    // Tipo de imagen (MIME)
                    $ordimg = $key + 1;         // Orden basado en posición 

                    $imagenesGuardadas[] = [
                        'imgpro' => $imgpro,
                        'nomimg' => $nomimg,
                        'tipimg' => $tipimg,
                        'ordimg' => $ordimg,
                    ];
                } else {
                    echo "Error al procesar $nombreOriginal<br>";
                }
            }

            // Insertar las imágenes en la base de datos
            if (!empty($imagenesGuardadas)) {
                try {
                    if ($ope == 'save') {
                        $res = $pro->saveProductoConImagenes($imagenesGuardadas, $caracteristicas);
                    }
                    if ($res) {
                        header("location:../views/vwpanpro.php?vw=001");
                    } else
                        echo "Error al guardar las imágenes en la base de datos.<br>";
                } catch (PDOException $e) {
                    error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
                    echo "Error al guardar las imágenes en la base de datos.<br>";
                }
            }
        }
        // Inserta el producto
        $idProducto = $res;

        // Inserta en la tabla prodxprov
        if ($idProveedor && $idProducto) {
            $prov->insertProdxProv($idProveedor, $idProducto);
        }
    }
}
if ($idpro && $ope == 'edit') {
    try {
        // Actualizar los datos principales del producto
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


        // Obtener las imágenes existentes
        $imagenesExistentes = isset($_POST['imagenesExistentes']) ? $_POST['imagenesExistentes'] : [];
        // Recoger las nuevas imágenes subidas
        $imagenesActualizadas = [];
        // Combinar imágenes existentes y nuevas
        foreach ($imagenesExistentes as $index => $imgpro) {
            $imagenesActualizadas[] = [
                'imgpro' => $imgpro,
                'nomimg' => pathinfo($imgpro, PATHINFO_FILENAME),
                'tipimg' => 'image/jpeg', // Ajusta el tipo según corresponda
                'ordimg' => $index + 1, // Orden inicial, puede ser temporal
            ];
        }

        // Si hay nuevas imágenes, agrégalas
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
                    $imgpro = $rutaFinal;
                    $nomimg = pathinfo($nombreOriginal, PATHINFO_FILENAME);
                    $tipimg = $archivo['type'];
                    $ordimg = $key + 1; // Orden inicial para nuevas imágenes

                    $imagenesActualizadas[] = [
                        'imgpro' => $imgpro,
                        'nomimg' => $nomimg,
                        'tipimg' => $tipimg,
                        'ordimg' => $ordimg,
                    ];
                }
            }
        }
        // Actualizar el orden basado en ordenImagenes
        if (isset($_POST['ordenImagenes'])) {
            $ordenImagenes = array_map(function ($item) {
                return json_decode($item, true);
            }, $_POST['ordenImagenes']);
            foreach ($ordenImagenes as $orden) {
                foreach ($imagenesActualizadas as &$imagen) {
                    if ($imagen['imgpro'] === $orden['imgpro']) {
                        $imagen['ordimg'] = $orden['ordimg'];
                        break;
                    }
                }
            }
        }
        // Actualizar las imágenes en la base de datos si hay imágenes nuevas o existentes
        if (!empty($imagenesActualizadas)) {
            $mpro->updateImagenesProducto($imagenesActualizadas);
        }

        // Actualizar características del producto
        if (!empty($caracteristicas)) {
            $mpro->updateCaracteristicas($caracteristicas, $idpro);
        }

        // Guardar cambios generales del producto
        if ($mpro->updateProducto()) {
            header("location:../views/vwpanpro.php?vw=001");
        } else {
            echo "Error al actualizar el producto.";
        }
    } catch (PDOException $e) {
        error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
        echo "Error al actualizar el producto en la base de datos.";
    }
}




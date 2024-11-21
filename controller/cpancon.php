<?php
session_start();
include "../model/conexion.php";
include "../model/mpancon.php";
include "../model/mprov.php";
include "../model/mpro.php";

$control = new Mpancon();
$prov = new Mprov();
$mpro = new Mpro();
$idusus = isset($_SESSION['idusu']) ? $_SESSION['idusu'] : null;
$idProveedor = $prov->existeProveedor($idusus);

$idusu = isset($_POST['idusu']) ? $_POST['idusu'] : null;
$nompro = isset($_POST['nompro']) ? $_POST['nompro'] : NULL;
$descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : NULL;
$cantidad = isset($_POST['cantidad']) ? $_POST['cantidad'] : NULL;
$idval = isset($_POST['idval']) ? $_POST['idval'] : NULL;
$valorunitario = isset($_POST['valorunitario']) ? $_POST['valorunitario'] : NULL;
$precio = isset($_POST['precio']) ? $_POST['precio'] : NULL;
$pordescu = isset($_POST['pordescu']) ? $_POST['pordescu'] : NULL;
$imgpro = isset($_FILES['imgpro']) ? $_FILES['imgpro'] : NULL;
$fechiniofer = isset($_POST['fechiniofer']) ? $_POST['fechiniofer'] : NULL;
$fechfinofer = isset($_POST['fechfinofer']) ? $_POST['fechfinofer'] : NULL;


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
                    $res = $pro->saveProductoConImagenes($imagenesGuardadas, $caracteristicas);

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

<?php
require_once '../model/conexion.php';
require '../vendor/autoload.php'; // PhpSpreadsheet
require '../model/mpro.php';
require '../model/mprov.php';
require '../model/mpancon.php'; // Para procesar imágenes

use PhpOffice\PhpSpreadsheet\IOFactory;

session_start();
$control = new Mpancon(); // Procesador de imágenes

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['archivo_excel'])) {
    $archivo = $_FILES['archivo_excel']['tmp_name'];

    try {
        $spreadsheet = IOFactory::load($archivo);
        $hoja = $spreadsheet->getActiveSheet();
        $datos = $hoja->toArray();

        $pro = new Mpro();
        $prov = new Mprov();

        $idusus = $_SESSION['idusu'] ?? null;
        $idProveedor = $idusus ? $prov->existeProveedor($idusus) : null;
        $errores = [];
        $productosGuardados = 0;
        $rutaImagenes = '../proinf/'; // Carpeta donde se guardarán las imágenes

        foreach ($datos as $index => $fila) {
            if ($index === 0)
                continue; // Omitir la fila de encabezado

            list($nompro, $descripcion, $cantidad, $valorunitario, $pordescu, $categoria) = $fila;

            // Validar datos mínimos
            if (empty($nompro) || empty($cantidad) || empty($valorunitario)) {
                $errores[] = "Fila " . ($index + 1) . ": Datos faltantes.";
                continue;
            }

            // Calcular el precio final con IVA, comisión y descuento
            $iva = 0.19;
            $comision = 0.07;
            $descuento = ($valorunitario * $pordescu) / 100;
            $precio = $valorunitario + ($valorunitario * $iva) + ($valorunitario * $comision) - $descuento;

            // Asignar valores al objeto
            $pro->setNompro($nompro);
            $pro->setDescripcion($descripcion);
            $pro->setCantidad($cantidad);
            $pro->setValorunitario($valorunitario);
            $pro->setPordescu($pordescu);
            $pro->setPrecio($precio);
            $pro->setIdval($categoria);

            // Procesar imágenes subidas en el formulario
            $imagenesGuardadas = [];
            if (!empty($_FILES['imagenes_productos']['name'][0])) {
                foreach ($_FILES['imagenes_productos']['name'] as $key => $nombreOriginal) {
                    $archivo = [
                        'name' => $_FILES['imagenes_productos']['name'][$key],
                        'tmp_name' => $_FILES['imagenes_productos']['tmp_name'][$key],
                        'type' => $_FILES['imagenes_productos']['type'][$key],
                        'size' => $_FILES['imagenes_productos']['size'][$key],
                    ];

                    $prefijo = uniqid();
                    $nombreBase = 'imagen';
                    $rutaFinal = $control->procesarImagen($archivo, $rutaImagenes, $nombreBase, $prefijo);

                    if ($rutaFinal) {
                        $imagenesGuardadas[] = [
                            'imgpro' => $rutaFinal,
                            'nomimg' => pathinfo($nombreOriginal, PATHINFO_FILENAME),
                            'tipimg' => $archivo['type'],
                            'ordimg' => $key + 1,
                        ];
                    } else {
                        $errores[] = "Error al procesar imagen: $nombreOriginal (Fila " . ($index + 1) . ")";
                    }
                }
            }

            // Guardar producto en la base de datos con sus imágenes
            $idProducto = $pro->saveProductoConImagenes($imagenesGuardadas, []);
    
            if ($idProducto) {
                $productosGuardados++;
                if ($idProveedor) {
                    $prov->insertProdxProv($idProveedor, $idProducto);
                }

                header("Location: ../views/vwpanpro.php?vw=23&prdg=$productosGuardados");
                exit();
            } else {
                $errores[] = "Fila " . ($index + 1) . ": No se pudo guardar el producto.";
            }
        }


        if (!empty($errores)) {
            echo "<br>Errores:<br>" . implode("<br>", $errores);
        }
    } catch (Exception $e) {
        echo "Error al procesar el archivo: " . $e->getMessage();
    }
} else {
    echo "No se recibió un archivo válido.";
}
?>
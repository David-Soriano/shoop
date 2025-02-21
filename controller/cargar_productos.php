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
                continue; // Saltar la fila de encabezado

            list($nompro, $descripcion, $cantidad, $valorunitario, $pordescu, $categoria) = $fila;

            if (empty($nompro) || empty($cantidad) || empty($valorunitario)) {
                $errores[] = "Fila " . ($index + 1) . ": Datos faltantes.";
                continue;
            }

            $iva = 0.19;
            $comision = 0.07;
            $pordescu = $pordescu ?? 0;
            $descuento = ($valorunitario * $pordescu) / 100;
            $precio = $valorunitario + ($valorunitario * $iva) + ($valorunitario * $comision) - $descuento;

            $pro->setNompro($nompro);
            $pro->setDescripcion($descripcion);
            $pro->setCantidad($cantidad);
            $pro->setValorunitario($valorunitario);
            $pro->setPordescu($pordescu);
            $pro->setPrecio($precio);
            $pro->setIdval($categoria);

            // Procesar imágenes del producto actual
            $imagenesGuardadas = [];
            if (!empty($_FILES['imagenes_productos']['name'][$index - 1])) { // Asegúrate de que el índice sea correcto
                foreach ($_FILES['imagenes_productos']['name'][$index - 1] as $key => $nombreOriginal) {
                    if (!empty($nombreOriginal)) {
                        $archivo = [
                            'name' => $_FILES['imagenes_productos']['name'][$index - 1][$key],
                            'tmp_name' => $_FILES['imagenes_productos']['tmp_name'][$index - 1][$key],
                            'type' => $_FILES['imagenes_productos']['type'][$index - 1][$key],
                            'size' => $_FILES['imagenes_productos']['size'][$index - 1][$key],
                        ];

                        $prefijo = uniqid();
                        $nombreBase = 'imagen';
                        $rutaFinal = $control->procesarImagen($archivo, $rutaImagenes, $nombreBase, $prefijo);

                        if ($rutaFinal) {
                            $imagenesGuardadas[] = [
                                'imgpro' => $rutaFinal,
                                'nomimg' => pathinfo($nombreOriginal, PATHINFO_FILENAME),
                                'tipimg' => $archivo['type'],
                                'ordimg' => count($imagenesGuardadas) + 1,
                            ];
                        } else {
                            $errores[] = "Error al procesar imagen: $nombreOriginal (Fila " . ($index + 1) . ")";
                        }
                    }
                }
            }

            // Guardar el producto y sus imágenes
            if (!empty($imagenesGuardadas)) {
                $idProducto = $pro->saveProductoConImagenes($imagenesGuardadas, []);

                if ($idProducto) {
                    if ($idProveedor) {
                        $prov->insertProdxProv($idProveedor, $idProducto);
                    }
                } else {
                    $errores[] = "Fila " . ($index + 1) . ": No se pudo guardar el producto.";
                }
            }
        }
        if (!empty($errores)) {
            echo "<br>Errores:<br>" . implode("<br>", $errores);
        } else {
            header("Location: ../views/vwpanpro.php?vw=23");
            exit();
        }
    } catch (Exception $e) {
        echo "Error al procesar el archivo: " . $e->getMessage();
    }
} else {
    echo "No se recibió un archivo válido.";
}
?>
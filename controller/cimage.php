<?php
require_once "../model/madmin.php";
require_once "../model/conexion.php";

// Función para mostrar imágenes
function mostrarImagenes()
{
    $admin = new Madmin();
    $imagenes = $admin->obtenerImagenes();

    header('Content-Type: application/json');

    if (!$imagenes) {
        echo json_encode(["error" => "No se encontraron imágenes"]);
        exit;
    }

    echo json_encode($imagenes);
}

// Función para guardar una nueva imagen
function guardarImagen()
{
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["imagen"])) {
        $archivo = $_FILES["imagen"];
        $extension = pathinfo($archivo["name"], PATHINFO_EXTENSION); // Extraer la extensión
        $nombreUnico = "publicidad_" . uniqid() . "." . $extension; // Generar nombre único

        $rutaDestino = "../IMG/publicidad/" . $nombreUnico;

        // Validar tipo de archivo
        $extensionesPermitidas = ["jpg", "jpeg", "png", "webp"];
        $extension = pathinfo($nombreUnico, PATHINFO_EXTENSION);

        if (!in_array(strtolower($extension), $extensionesPermitidas)) {
            echo json_encode(["success" => false, "message" => "Formato no permitido"]);
            exit;
        }

        // Validar tamaño máximo (5MB)
        if ($archivo["size"] > 5 * 1024 * 1024) {
            echo json_encode(["success" => false, "message" => "Archivo demasiado grande"]);
            exit;
        }

        // Mover archivo a la carpeta de imágenes
        if (move_uploaded_file($archivo["tmp_name"], $rutaDestino)) {
            $admin = new Madmin();
            $admin->setImgpro("IMG/publicidad/" . $nombreUnico);
            $admin->setNomimg($nombreUnico);
            $admin->setTipimg($extension);
            $admin->setOrdimg(1);
            $admin->setUrlimg(NULL); // Si hay una URL pública, agrégala aquí

            $resultado = $admin->savePublicidad();
            echo json_encode($resultado);
        } else {
            echo json_encode(["success" => false, "message" => "Error al mover el archivo"]);
        }
    }
}

function eliminarImagen($idimag)
{
    $admin = new Madmin();
    $resultado = $admin->eliminarImagen($idimag);

    // 🛠️ Asegurar que no haya salida extra antes de enviar JSON
    header("Content-Type: application/json");
    echo json_encode(["success" => $resultado]);
    exit; // 🚀 Importante para evitar contenido extra
}

// 🛠️ Control de rutas y validación de método
// Control de rutas
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    mostrarImagenes();
} elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
    guardarImagen();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["accion"])) {

    if ($_POST["accion"] === "eliminar" && isset($_POST["idimag"])) {
        $idimag = intval($_POST["idimag"]); // Asegurar que es un número válido
        eliminarImagen($idimag); // ✅ Llamar la función directamente, ya hace `echo json_encode()`
    } else {
        header("Content-Type: application/json");
        echo json_encode(["success" => false, "message" => "Parámetros incorrectos"]);
    }
}
?>
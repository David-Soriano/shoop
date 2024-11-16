<?php
class Mpancon
{
    public function getCategorías()
    {
        $res = "";
        $sql = "SELECT v.idval, v.nomval AS categoria FROM valor v JOIN dominio d ON v.iddom = d.iddom WHERE d.nomdom = 'Categorías';";
        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $result = $conexion->prepare($sql);
            $result->execute();
            $res = $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            echo "Error al obtener las categorías. Intentalo más tarde.";
        }
        return $res;
    }
    function procesarImagen($archivo, $ruta, $nombreBase, $prefijo, $maxAncho = 1024, $maxAlto = 800, $calidad = 80)
    {
        $rutaFinal = '';
        if ($archivo) {
            $ext = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));
            $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'webp'];  // Añadido WebP

            if (in_array($ext, $extensionesPermitidas)) {
                list($anchoOriginal, $altoOriginal) = getimagesize($archivo['tmp_name']);

                // Calcular proporciones para redimensionar
                $factor = min($maxAncho / $anchoOriginal, $maxAlto / $altoOriginal, 1);
                $nuevoAncho = (int) ($anchoOriginal * $factor);
                $nuevoAlto = (int) ($altoOriginal * $factor);

                // Crear una nueva imagen en memoria
                $imagenRedimensionada = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

                // Crear la imagen original según el formato
                switch ($ext) {
                    case 'jpg':
                    case 'jpeg':
                        $imagenOriginal = imagecreatefromjpeg($archivo['tmp_name']);
                        break;
                    case 'png':
                        $imagenOriginal = imagecreatefrompng($archivo['tmp_name']);
                        // Hacer el fondo transparente si es PNG
                        imagealphablending($imagenRedimensionada, false);
                        imagesavealpha($imagenRedimensionada, true);
                        break;
                    case 'webp':
                        $imagenOriginal = imagecreatefromwebp($archivo['tmp_name']);  // Cargar imagen WebP
                        break;
                    default:
                        return false;
                }

                // Redimensionar la imagen
                imagecopyresampled($imagenRedimensionada, $imagenOriginal, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $anchoOriginal, $altoOriginal);

                // Generar el nombre final y guardar la imagen
                $rutaFinal = $ruta . '/' . $nombreBase . '_' . $prefijo . '.' . $ext;
                switch ($ext) {
                    case 'jpg':
                    case 'jpeg':
                        imagejpeg($imagenRedimensionada, $rutaFinal, $calidad);
                        break;
                    case 'png':
                        $compresionPng = (int) ((100 - $calidad) / 10); // 0 (mejor calidad) a 9 (máxima compresión)
                        imagepng($imagenRedimensionada, $rutaFinal, $compresionPng);
                        break;
                    case 'webp':
                        imagewebp($imagenRedimensionada, $rutaFinal, $calidad);  // Guardar como WebP
                        break;
                }

                // Liberar memoria
                imagedestroy($imagenRedimensionada);
                imagedestroy($imagenOriginal);
            } else {
                echo "<script>alert('Formato de archivo no permitido. Solo JPG, PNG y WebP.');</script>";
            }
        }
        return $rutaFinal;
    }


}
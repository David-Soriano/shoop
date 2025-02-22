<?php

class Madmin
{

    private $imgpro;
    private $nomimg;
    private $tipimg;
    private $ordimg;
    private $lugimg;
    private $urlimg;

    // Getters
    public function getImgpro() {
        return $this->imgpro;
    }

    public function getNomimg() {
        return $this->nomimg;
    }

    public function getTipimg() {
        return $this->tipimg;
    }

    public function getOrdimg() {
        return $this->ordimg;
    }

    public function getLugimg() {
        return $this->lugimg;
    }

    public function getUrlimg() {
        return $this->urlimg;
    }

    // Setters
    public function setImgpro($imgpro) {
        $this->imgpro = $imgpro;
    }

    public function setNomimg($nomimg) {
        $this->nomimg = $nomimg;
    }

    public function setTipimg($tipimg) {
        $this->tipimg = $tipimg;
    }

    public function setOrdimg($ordimg) {
        $this->ordimg = $ordimg;
    }

    public function setLugimg($lugimg) {
        $this->lugimg = $lugimg;
    }

    public function setUrlimg($urlimg) {
        $this->urlimg = $urlimg;
    }
    function getImgItem()
    {
        $res = "";
        $sql = "SELECT imgpro, nomimg, ordimg, lugimg, urlimg FROM imagen WHERE lugimg = 2 ORDER BY ordimg";
        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $result = $conexion->prepare($sql);
            $result->execute();
            $res = $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage(), 3, "'C:/xampp\htdocs/SHOOP/errors/error_log.log'");
            echo "Error al obtener imagenes de items.";
        }
        return $res;
    }
    function getPaginas()
    {
        $res = "";
        $sql = 'SELECT p.idpag AS "ID Página", p.nompag AS "Nombre Página", p.rutpag AS "Ruta Página", p.mospag AS "Mostrar Página", p.icopag AS "Ícono", p.lugpag AS "Lugar Página", pe.idpef AS "ID Perfil", pe.nompef AS "Perfil", pe.pagini AS "Página Inicial" FROM pagina p LEFT JOIN pagxperfil pxp ON p.idpag = pxp.idpag LEFT JOIN perfil pe ON pxp.idpef = pe.idpef ORDER BY p.idpag, pe.idpef';
        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $result = $conexion->prepare($sql);
            $result->execute();
            $res = $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage(), 3, "'C:/xampp\htdocs/SHOOP/errors/error_log.log'");
            echo "Error al obtener imagenes de items.";
        }
        return $res;
    }
    public function obtenerImagenes()
    {
        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $sql = "SELECT idimag, imgpro, nomimg FROM imagen WHERE lugimg = 1";
            $stmt = $conexion->prepare($sql);
            $stmt->execute();
            $imagenes = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // 🛠️ DEPURACIÓN: Imprimir resultado en el servidor
            error_log(print_r($imagenes, true));

            return $imagenes;
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            return [];
        }
    }
    public function savePublicidad() {
        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            
            $sql = "INSERT INTO imagen (imgpro, nomimg, tipimg, ordimg, lugimg, urlimg) 
                    VALUES (:imgpro, :nomimg, :tipimg, :ordimg, :lugimg, :urlimg)";
            $stmt = $conexion->prepare($sql);
    
            // Obtener valores de la clase
            $imgpro = $this->getImgpro();
            $nomimg = $this->getNomimg();
            $tipimg = $this->getTipimg();
            $ordimg = $this->getOrdimg();
            $lugimg = 1; // Siempre será 1
            $urlimg = $this->getUrlimg();
    
            // Asignar valores a los parámetros
            $stmt->bindParam(":imgpro", $imgpro);
            $stmt->bindParam(":nomimg", $nomimg);
            $stmt->bindParam(":tipimg", $tipimg);
            $stmt->bindParam(":ordimg", $ordimg);
            $stmt->bindParam(":lugimg", $lugimg);
            $stmt->bindParam(":urlimg", $urlimg);
    
            // Ejecutar la consulta
            if ($stmt->execute()) {
                return ["success" => true, "message" => "Imagen guardada correctamente", "id" => $conexion->lastInsertId()];
            } else {
                return ["success" => false, "message" => "Error al guardar la imagen"];
            }
        } catch (PDOException $e) {
            // Guardar errores en un log
            error_log($e->getMessage(), 3, 'C:/xampp/htdocs/SHOOP/errors/error_log.log');
            return ["success" => false, "message" => "Error en la base de datos"];
        }
    }
    public function eliminarImagen($idimag) {
        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            
            // Obtener el nombre de la imagen para eliminar el archivo físico
            $sql = "SELECT imgpro FROM imagen WHERE idimag = :idimag";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(":idimag", $idimag, PDO::PARAM_INT);
            $stmt->execute();
            $imagen = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($imagen) {
                $rutaImagen = "../" . $imagen["imgpro"];
                if (file_exists($rutaImagen)) {
                    unlink($rutaImagen); // Eliminar archivo físico
                }
    
                // Eliminar de la base de datos
                $sql = "DELETE FROM imagen WHERE idimag = :idimag";
                $stmt = $conexion->prepare($sql);
                $stmt->bindParam(":idimag", $idimag, PDO::PARAM_INT);
                return $stmt->execute(); // Retorna true si se eliminó correctamente
            }
            
            return false;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }
    


}
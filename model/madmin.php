<?php

class Madmin{
    function getImgItem(){
        $res = "";
        $sql = "SELECT imgpro, nomimg, ordimg, lugimg FROM imagen WHERE lugimg = 2 ORDER BY ordimg";
        try{
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $result = $conexion->prepare($sql);
            $result->execute();
            $res = $result->fetchAll(PDO::FETCH_ASSOC);
        } catch(Exception $e){
            error_log($e->getMessage(), 3, "'C:/xampp\htdocs/SHOOP/errors/error_log.log'");
            echo "Error al obtener imagenes de items.";
        }
        return $res;
    }
}
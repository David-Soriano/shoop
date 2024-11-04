<?php
class Mpro
{
        public function obtenerProductos()
    {
        $res = "";
        $sql = "SELECT p.idpro, p.nompro, p.precio, p.descripcion, p.estado, i.imgpro 
                FROM producto p 
                LEFT JOIN imagen i ON p.idpro = i.idpro
                WHERE p.estado = 'activo' 
                GROUP BY p.idpro";
        try {
            $modelo = new Conexion();
            $conexion = $modelo->getConexion();
            $result = $conexion->prepare($sql);
            $result->execute();
            $res = $result->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, 'C:/xampp\htdocs/SHOOP/errors/error_log.log');
            echo "Error al obtener productos. Intentalo mas tarde";
        }
        return $res;
    }
}

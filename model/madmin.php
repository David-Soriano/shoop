<?php

class Madmin
{
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
}
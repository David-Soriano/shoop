<?php
class Conexion
{
    function getConexion()
    {
        include "datos.php";
        $conect = new PDO("mysql:host=$host;dbname=$db;", $user, $pass);
        if ($conect) {
            return $conect;
        } else {
            echo "No hay conexion con la base de datos.";
        }
    }
}

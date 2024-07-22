<?php
class Conexion
{
    function getConexion()
    {
        include "datos.php";
        $conect = new PDO("mysql:host=$host;dbname=$db;", $user, $pass);
        return $conect;
    }
}

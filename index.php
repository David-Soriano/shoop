<?php 
ini_set("display_errors", 0);
ini_set("log_errors", 1);
ini_set("error_log", "C:/xampp\htdocs/SHOOP/errors/error_log.log");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="CSS/bootstrap.min.css">
    <link rel="stylesheet" href="CSS/styleIndex.css">
    <link rel="shortcut icon" href="IMG/Logo-oscuro.png" type="image/x-icon">
    <title>SHOOP S.A</title>
</head>

<body>
    <?php require_once("views/vwHeader.php");
    include "model/conexion.php";
    include("controller/funciones.php");
    include("controller/cpag.php");
    $pg = isset($_REQUEST["pg"]) ? $_REQUEST["pg"] : NULL;
    //$excluirVistas = array("001", "002", "003", "1001", "1002", "1004", "1005", "1006", "1007", "1008", "1009", "1010", "1011", "1012", "1013", "1014", "1015", "1016", "10013", "10014", "10015");
    ?>
    <nav class="nav-men">
    <ul class="men-hrz">
        <?php echo insertMenu(2, "index.php?pg=1002", "#", "index.php?pg=1004", "index.php?pg=1005", "index.php?pg=10015", "views/vwLogin.php");?>
    </ul>
    </nav>
    <main id="bx-section">
        <?php
        $rut = getRut($pg);
        var_dump($rut);
        var_dump($pg);
        var_dump($dtMenu);
        
        if($rut) include $rut[0]['rutpag'];
        // if (!in_array($pg, $excluirVistas)) {
        //     require_once("views/vwTienda.php");
        // }
        // // Incluir otras vistas según el valor de $pg
        // if ($pg == "001") {
        //     require_once("views/vwInfoPrd.php");
        // } else if ($pg == "002") {
        //     require_once("views/vwFavorito.php");
        // } else if ($pg == "003") {
        //     require_once("views/vwCarrComp.php");
        // } else if ($pg == "1001") {
        //     require_once("views/vwLogin.php");
        // } else if ($pg == "1002") {
        //     require_once("views/vwNosotros.php");
        // } else if ($pg == "1004") {
        //     require_once("views/vwfaq.php");
        // } else if ($pg == "1005") {
        //     require_once("views/vwRecuredu.php");
        // } else if ($pg == "1006") {
        //     require_once("views/vwsoport.php");
        // } else if ($pg == "1007") {
        //     require_once("views/vwpagos.php");
        // } else if ($pg == "1008") {
        //     require_once("views/vwpedido.php");
        // } else if ($pg == "1009") {
        //     require_once("views/vwfaq.php");
        // } else if ($pg == "1015") {
        //     require_once("views/vwPoliticas.php");
        // } else if ($pg == "10013") {
        //     require_once("views/vwtarjeta.php");
        // } else if ($pg == "10014") {
        //     require_once("views/vwRecuredu.php");
        // } else if ($pg == "10015") {
        //     require_once("views/vwsoport.php");
        // }
        ?>
    </main>

    <?php require_once("views/vwFooter.php"); ?>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="JS/bootstrap.min.js"></script>

    <script src="JS/script.js"></script>
    <script src="https://kit.fontawesome.com/e2ac9cc532.js" crossorigin="anonymous"></script>
</body>
</html>
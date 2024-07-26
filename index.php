<?php
ini_set("display_errors", 1);
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
    <?php require_once ("views/vwHeader.php");
    include "model/conexion.php";
    include ("controller/funciones.php");
    include ("controller/cpag.php");
    $pg = isset($_REQUEST["pg"]) ? $_REQUEST["pg"] : NULL;

    include "views/vwMenu.php"; ?>

    <main id="bx-section">
        <?php
        $rut = getRut($pg);

        if ($rut)
            include $rut[0]['rutpag'];
        ?>
    </main>

    <?php require_once ("views/vwFooter.php"); ?>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="JS/bootstrap.min.js"></script>

    <script src="JS/script.js"></script>
    <script src="https://kit.fontawesome.com/e2ac9cc532.js" crossorigin="anonymous"></script>
</body>

</html>
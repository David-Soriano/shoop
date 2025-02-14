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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>SHOOP S.A</title>
</head>

<body>
    <?php include "model/conexion.php";
    include("controller/funciones.php");
    include("controller/cpag.php");
    include("controller/cpro.php");
    require_once("views/vwHeader.php");
    $pg = isset($_REQUEST["pg"]) ? $_REQUEST["pg"] : NULL;

    include "views/vwMenu.php"; ?>

    <main id="bx-section">
        <?php
        if($pg)
            $rut = getRut($pg);
        else
            $rut = getRut(14);
        if ($rut)
            include $rut[0]['rutpag'];
        else echo "<div class='bx-404'><img src='IMG/404.svg' alt='404'>
        <p class='msj-404'>Estamos trabajando para volver a estar en línea.</p></div>";
        ?>
    </main>

    <?php require_once("views/vwFooter.php"); ?>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="JS/bootstrap.min.js"></script>

    <script src="JS/script.js"></script>
    <script src="https://kit.fontawesome.com/e2ac9cc532.js" crossorigin="anonymous"></script>
</body>

</html>

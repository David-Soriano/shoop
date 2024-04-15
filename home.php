<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/bootstrap.min.css">
    <link rel="stylesheet" href="CSS/styleIndex.css">
    <title>Tienda G.I.L</title>
</head>

<body>
    <?php require_once ("views/vwHeader.php"); ?>
    <?php include("controller/funciones.php");
    
    $excluirVistas = array("001", "002", "003", "1001", "1002", "1003", "1004", "1005", "1006", "1007", "1008", "1009", "1010", "1011", "1012", "1013", "1014", "1015", "1016","10014");
    ?>
    <nav class="nav-men">
    <ul class="men-hrz">
        <?php echo insertMenu(1, "home.php?pg=1002", "#", "home.php?pg=1004", "home.php?pg=1005", "home.php?pg=1006", "views/vwpanpro.php");?>
    </ul>
</nav>
    <section id="bx-section">
        <?php
        $pg = isset($_GET["pg"]) ? $_GET["pg"] : NULL;

        if (!in_array($pg, $excluirVistas)) {
            require_once ("views/vwSlider.php");
            insertText("Productos hechos para ti");
            require_once ("views/vwTienda.php");
        }
        // Incluir otras vistas según el valor de $pg
        if ($pg == "001") {
            require_once ("views/vwInfoPrd.php");
        } else if ($pg == "002") {
            require_once ("views/vwFavorito.php");
        } else if ($pg == "003") {
            require_once ("views/vwCarrComp.php");
        } else if ($pg == "1001") {
            require_once ("views/vwLogin.php");
        } else if ($pg == "1002") {
            require_once ("views/vwNosotros.php");
        // } else if ($pg == "1003") {
        //     require_once ("views/vwpanpro.php");
        // } 
        } else if ($pg == "1004") {
            require_once ("views/vwfaq.php");
        } else if ($pg == "1005") {
            require_once ("views/vwRecuredu.php");
        } else if ($pg == "1006") {
            require_once ("views/vwsoport.php");
        } else if ($pg == "1007") {
            require_once ("views/vwpagos.php");
        } else if ($pg == "1008") {
            require_once ("views/vwpedido.php");
        } else if ($pg == "1015") {
            require_once ("views/vwPoliticas.php");
        } else if ($pg == "10013") {
            require_once("views/vwtarjeta.php");
        } else if ($pg == "10014") {
            require_once("views/vwpanpro.php");
        }
        ?>
    </section>

    <?php require_once("views/vwFooter.php"); ?>
    
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="JS/bootstrap.min.js"></script>
    <script src="JS/script.js"></script>
    <script src="https://kit.fontawesome.com/e2ac9cc532.js" crossorigin="anonymous"></script>  
</body>

</html>
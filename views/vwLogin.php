<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.9/css/unicons.css">
    <link rel="stylesheet" href="../CSS/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/styleLogin.css">
    <link rel="shortcut icon" href="../IMG/Logo-oscuro.png" type="image/x-icon">
    <title>LogIn G.I.L</title>
</head>

<body>
    <div class="section">
        <div class="container">
            <?php $vistasOcultas = array("01", "02");
            $aw = isset($_REQUEST["aw"]) ? $_REQUEST["aw"] : NULL;
            if(!in_array($aw, $vistasOcultas)){
                require_once("vwInitUser.php");
            } 
            if($aw == "01"){
                require_once("vwRecContrasena.php");
            } else if($aw == "02"){
                require_once("vwToken.php");
            }
            ?>
        </div>
    </div>
    <script src="../JS/script.js"></script>
</body>

</html>
<?php
require_once("../model/conexion.php");
require_once("../model/mprov.php");
include "../controller/cubi.php";

ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1);
ini_set('session.cookie_samesite', 'Strict');
session_start();

$prov = new Mprov();
$idusu = isset($_SESSION['idusu']) ? $_SESSION['idusu'] : null;
$nomusu = isset($_SESSION['nomusu']) ? $_SESSION['nomusu'] : null;

// Capturar la variable 'inc' de la URL
$inc = isset($_GET['inc']) ? $_GET['inc'] : 0;

$modelo = new Conexion();
$conexion = $modelo->getConexion();
$idProveedor = $prov->existeProveedor($idusu);
// Consultar el estado del proveedor
$sql = "SELECT estprv FROM proveedor WHERE idprov = :idprov";
$stmt = $conexion->prepare($sql);
$stmt->bindValue(':idprov', $idProveedor, PDO::PARAM_INT);
$stmt->execute();
$proveedor = $stmt->fetch(PDO::FETCH_ASSOC);

// Verificar si el proveedor ya existe
if ($idProveedor && $proveedor == "activo") {
    header('Location:../controller/cpancon.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../CSS/stylepancon.css">
    <title>Registro</title>
</head>

<body class="background">
    <div class="container bx-reg-prv">
        <?php if ($inc == 1) { ?>
            <div class="alert alert-warning text-center">
                <p>Tu cuenta está inactiva. ¿Quieres reactivarla?</p>
                <form method="post" action="../controller/cprov.php">
                    <input type="hidden" name="oper" value="reactivar">
                    <input type="hidden" name="idusu" value="<?= $idusu ?>">
                    <button class="btn btn-success" type="submit">Reactivar cuenta</button>
                </form>
            </div>
        <?php } else { ?>
            <div class="row">
                <div class="col">
                    <h4 class="line-1 anim-typewriter">¡Regístrate como Proveedor!</h4>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <form id="proveedorForm" method="post" action="../controller/cprov.php">
                        <div id="step1">
                            <label for="nomprov">Nombre del Proveedor:</label>
                            <input type="text" name="nomprov" id="nomprov" value="<?= $nomusu ?>" required>
                            <input type="hidden" name="idusu" value="<?= $idusu ?>">
                            <button class="btn" type="button" onclick="nextStep(2)">Siguiente</button>
                            <a href="../home.php" class="btn">Volver al inicio</a>
                        </div>

                        <div id="step2" style="display:none;">
                            <label for="dirrecprov">Dirección del Proveedor:</label>
                            <input type="text" name="dirrecprov" id="dirrecprov">

                            <label for="idubi">Ubicación:</label>
                            <select class="form-select" name="idubi" id="idubi" required>
                                <option value="">Seleccione</option>
                                <?php if ($dtDtp) {
                                    foreach ($dtDtp as $dtD) { ?>
                                        <option value="<?= $dtD['idubi']; ?>"><?= $dtD['nomubi']; ?></option>
                                    <?php }
                                } ?>
                            </select>

                            <label for="url">URL de la Página (opcional):</label>
                            <input type="url" name="url" id="url">

                            <button class="btn" type="button" onclick="nextStep(1)">Volver</button>
                            <button class="btn" type="button" onclick="nextStep(3)">Siguiente</button>
                        </div>

                        <div id="step3" style="display:none;">
                            <label for="nit">NIT del Proveedor (opcional):</label>
                            <input type="text" name="nit" id="nit">
                            <button class="btn" type="button" onclick="nextStep(2)">Volver</button>
                            <button class="btn" type="button" onclick="nextStep(4)">Siguiente</button>
                        </div>

                        <div id="step4" style="display:none;">
                            <label for="desprv">Descripción del Proveedor:</label>
                            <textarea name="desprv" id="desprv" required></textarea>
                            <input type="hidden" name="estado" value="activo">
                            <button class="btn" type="button" onclick="nextStep(3)">Volver</button>
                            <button class="btn btn-primary" type="submit">Registrar Proveedor</button>
                        </div>
                    </form>
                </div>
            </div>
        <?php } ?>
    </div>

    <script src="../JS/script2.js"></script>
</body>

</html>
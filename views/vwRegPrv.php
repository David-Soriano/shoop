<?php require_once("../model/conexion.php");
require_once("../model/mprov.php");

include "../controller/cubi.php";
ini_set('session.cookie_httponly', 1);  // Evita que JavaScript acceda a las cookies
ini_set('session.cookie_secure', 1);    // Solo permite el envío de cookies a través de HTTPS
ini_set('session.cookie_samesite', 'Strict');
session_start();

$prov = new Mprov(); // Crear un objeto de la clase Mprov
// Variables de sesión
$idusu = isset($_SESSION['idusu']) ? $_SESSION['idusu'] : null;
$nomusu = isset($_SESSION['nomusu']) ? $_SESSION['nomusu'] : null;

if ($prov->existeProveedor($idusu)) {
    header('Location:../controller/cpancon.php');
} else {
    ?>
    <!DOCTYPE html>
    <html lang="en">

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
            <div class="row">
                <div class="col">
                    <h4 class="line-1 anim-typewriter">¡Registrate como Proveedor!</h4>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <form id="proveedorForm" method="post" action="../controller/cprov.php">
                        <!-- Parte 1: Nombre del proveedor -->
                        <div id="step1">
                            <label for="nomprov">Nombre del Proveedor:</label>
                            <input type="text" name="nomprov" id="nomprov" value="<?= $nomusu ?>" required>
                            <input type="hidden" name="idusu" value="<?= $idusu ?>">
                            <!-- Se guarda automáticamente el ID de usuario -->

                            <button class="btn" type="button" onclick="nextStep(2)">Siguiente</button>
                        </div>

                        <!-- Parte 2: Dirección y URL -->
                        <div id="step2" style="display:none;">
                            <label for="dirrecprov">Dirección del Proveedor:</label>
                            <input type="text" name="dirrecprov" id="dirrecprov">

                            <label for="idubi">Ubicación:</label>
                            <select class="form-select" name="idubi" id="idubi" required>
                                <!-- Aquí puedes llenar las opciones de IDUBI desde la base de datos -->
                                <option value="">Seleccione</option>
                                <?php if ($dtDtp) {
                                    foreach ($dtDtp as $dtD) { ?>
                                        <option value="<?= $dtD['idubi']; ?>"><?= $dtD['nomubi']; ?></option>
                                    <?php }
                                } ?>
                            </select>

                            <label for="url">URL de la Página (opcional):</label>
                            <input type="url" name="url" id="url">

                            <button class="btn" type="button" onclick="nextStep(3)">Siguiente</button>
                        </div>

                        <!-- Parte 3: NIT -->
                        <div id="step3" style="display:none;">
                            <label for="nit">NIT del Proveedor (opcional):</label>
                            <input type="text" name="nit" id="nit">

                            <button class="btn" type="button" onclick="nextStep(4)">Siguiente</button>
                        </div>

                        <!-- Parte 4: Descripción -->
                        <div id="step4" style="display:none;">
                            <label for="desprv">Descripción del Proveedor:</label>
                            <textarea name="desprv" id="desprv" required></textarea>
                                <input type="hidden" value="activo">
                            <button class="btn" type="submit">Registrar Proveedor</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>

    </html>
<?php } ?>
<script src="../JS/script2.js"></script>
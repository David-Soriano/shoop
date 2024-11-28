<?php include("../model/conexion.php");
include "../model/mprov.php";
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
    <form id="proveedorForm" method="post" action="../controller/cpancon.php">
        <!-- Parte 1: Nombre del proveedor -->
        <div id="step1">
            <label for="nomprov">Nombre del Proveedor:</label>
            <input type="text" name="nomprov" id="nomprov" value="<?= $nomusu ?>" required>
            <input type="hidden" name="idusu" value="<?= $idusu ?>"> <!-- Se guarda automáticamente el ID de usuario -->

            <button type="button" onclick="nextStep(2)">Siguiente</button>
        </div>

        <!-- Parte 2: Dirección y URL -->
        <div id="step2" style="display:none;">
            <label for="dirrecprov">Dirección del Proveedor:</label>
            <input type="text" name="dirrecprov" id="dirrecprov" required>

            <label for="idubi">Ubicación:</label>
            <select name="idubi" id="idubi" required>
                <!-- Aquí puedes llenar las opciones de IDUBI desde la base de datos -->
                <option value="5">Ubicación 1</option>
                <option value="8">Ubicación 2</option>
                <option value="11">Ubicación 3</option>
            </select>

            <label for="url">URL de la Página (opcional):</label>
            <input type="url" name="url" id="url">

            <button type="button" onclick="nextStep(3)">Siguiente</button>
        </div>

        <!-- Parte 3: NIT -->
        <div id="step3" style="display:none;">
            <label for="nit">NIT del Proveedor (opcional):</label>
            <input type="text" name="nit" id="nit">

            <button type="button" onclick="nextStep(4)">Siguiente</button>
        </div>

        <!-- Parte 4: Descripción -->
        <div id="step4" style="display:none;">
            <label for="desprv">Descripción del Proveedor:</label>
            <textarea name="desprv" id="desprv" required></textarea>

            <button type="submit">Registrar Proveedor</button>
        </div>
    </form>
<?php } ?>
<script src="../JS/script2.js"></script>
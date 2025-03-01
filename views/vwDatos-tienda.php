<?php session_start(); 
require_once("../controller/cpancon.php");
$dtProvData = getDtProv($_SESSION['idprov']);
$dtProv = $dtProvData[0];?>
<div class="bx-content-pf">
<h3>Datos de tu Tienda</h3>
<form id="formDatosCuenta" class="form-conf-pef" method="POST" action="../controller/cprov.php">
    <label for="url">Tu sitio web - URL (Opcional):</label>
    <input type="text" id="urlt" name="urlt" value="<?= $dtProv['urlt'] ?>" placeholder="https://www.tutienda.com">

    <label for=nit">NIT:</label>
    <input type="text" id="nit" name="nit" value="<?= $dtProv['nit'] ?>" placeholder="Escribe tu NIT">

    <input type="hidden" name="idprov" value="<?= $dtProv['idprov'] ?>">
    <input type="hidden" name="oper" value="editPrv2">
    <button type="submit" class="btn btn-primary">Actualizar Datos</button>
</form>

<div id="mensajeDatosCuenta"></div>
</div>

<?php session_start(); 
require_once("../controller/cpancon.php");
$dtProvData = getDtProv($_SESSION['idprov']);
$dtProv = $dtProvData[0];?>
<div class="bx-content-pf">
    <h3>Información Genral</h3>
    <form id="formInfoPersonal" class="form-conf-pef" method="post" action="../controller/cprov.php">
        <label for="nomprov">Nombre de la Tienda:</label>
        <input type="text" id="nomprov" name="nomprov" value="<?= $dtProv['nomprov'] ?>" required>

        <label for="apeusu">Descripción:</label>
       <textarea name="desprv" id="desprv" ><?= $dtProv['desprv'] ?></textarea>

        <input type="hidden" name="idprov" value="<?= $dtProv['idprov'] ?>">
        <input type="hidden" name="oper" value="editPrv1">
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </form>

    <div id="mensajeInfoPersonal"></div>
</div>

<?php session_start(); ?>
<div class="bx-content-pf">
<h3>Datos de tu Cuenta</h3>
<form id="formDatosCuenta" class="form-conf-pef" method="POST" action="controller/cusu.php">
    <label for="usuario">Usuario:</label>
    <input type="text" id="usuario" name="usuario" value="<?= $_SESSION['emausu'] ?>" disabled>

    <label for="pasusu2">Contraseña Actual:</label>
    <input type="password" id="pasusu2" name="pasusu2" required>

    <label for="pasusu">Nueva Contraseña:</label>
    <input type="password" id="pasusu" name="pasusu" required>
    <input type="hidden" name="ope" value="editPass">
    <button type="submit" class="btn btn-primary">Actualizar Datos</button>
</form>

<div id="mensajeDatosCuenta"></div>
</div>

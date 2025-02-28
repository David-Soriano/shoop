<?php session_start(); ?>
<div class="bx-content-pf">
    <h3>Información Personal</h3>
    <form id="formInfoPersonal" class="form-conf-pef" method="post" action="controller/cusu.php">
        <label for="nomusu">Nombre:</label>
        <input type="text" id="nomusu" name="nomusu" value="<?= $_SESSION['nomusu'] ?>" required>

        <label for="apeusu">Apellido:</label>
        <input type="text" id="apeusu" name="apeusu" value="<?= $_SESSION['apeusu'] ?>" required>

        <label for="emausu">Correo:</label>
        <input type="email" id="emausu" name="emausu" value="<?= $_SESSION['emausu'] ?>" required>
        <label for="emausu">Teléfono:</label>
        <input type="email" id="celusu" name="celusu" value="<?= $_SESSION['celusu'] ?>" required>
        <input type="hidden" name="idusu" value="<?= $_SESSION['idusu'] ?>">
        <input type="hidden" name="ope" value="edit">
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </form>

    <div id="mensajeInfoPersonal"></div>
</div>

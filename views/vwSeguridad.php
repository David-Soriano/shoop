<div class="bx-content-pf">
    <h3>Seguridad</h3>
    <form id="formSeguridad" class="form-conf-pef">
    <label for="activar2FA">Autenticación en dos pasos:</label>
    <select id="activar2FA" name="activar2FA">
        <option value="0">Desactivado</option>
        <option value="1">Activado</option>
    </select>

    <label for="notificaciones">Notificaciones de seguridad:</label>
    <select id="notificaciones" name="notificaciones">
        <option value="0">No</option>
        <option value="1">Sí</option>
    </select>

    <button type="submit" class="btn btn-primary">Guardar Configuración</button>
</form>

<div id="mensajeSeguridad"></div>
</div>

<script>
$("#formSeguridad").submit(function(event) {
    event.preventDefault();
    $.post("controllers/updateSeguridad.php", $(this).serialize(), function(response) {
        $("#mensajeSeguridad").html(response);
    });
});
</script>
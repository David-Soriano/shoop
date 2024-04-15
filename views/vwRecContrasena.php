<div class="container bx-rec-con">
    <div class="row d-flex justify-content-center">
        <div class="rec-con col-5" id="bx-rec-corr">
            <h3>Recuperar Contraseña</h3>
            <form action="vwLogin.php?aw=02" class="d-flex flex-column" method="POST">
                <label for="correo">Correo Electrónico</label>
                <input type="email" name="correo" id="correo" required
                    onkeyup="leerCorreo('correo', 'span1-corr', 'span2-corr')">
                <p>Enviar codigo a: <span class="res-corr" id="span1-corr">No hay Correo</span></p>
                <input class="inp-link" id="btn-envcod" type="submit" value="Enviar">
            </form>
            <a href="vwLogin.php"><input type="button" value="Volver" class="inp-link" id="btn-vol1"></a>
            <img id="logo" src="../IMG/Logo-oscuro.png" alt="Logo GIL">
        </div>
    </div>
</div>
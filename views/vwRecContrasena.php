<div class="container bx-rec-con">
    <div class="row d-flex justify-content-center">
        <div class="rec-con col-5" id="bx-rec-corr">
            <h3>Recuperar Contraseña</h3>
            <form action="" class="d-flex flex-column" method="POST" id="recuperar-form">
                <label for="correo">Correo Electrónico</label>
                <input type="email" name="correo" id="correo" required
                    onkeyup="setupLeerCorreo('correo', 'span1-corr')">
                <p>Enviar codigo a: <span class="res-corr" id="span1-corr">No hay Correo</span></p>
                <input class="inp-link" id="btn-envcod" type="submit" value="Enviar">
            </form>
            <p id="mensaje"></p>
            <a href="vwLogin.php"><input type="button" value="Volver" class="inp-link" id="btn-vol1"></a>
        </div>
    </div>
</div>

<script>
document.getElementById("recuperar-form").addEventListener("submit", function(event) {
    event.preventDefault();
    
    let correo = document.getElementById("correo").value;
    console.log('Correo:', correo); // Depuración para verificar que se captura el correo

    fetch('../controller/recuperarController.php', {
        method: "POST",
        body: new URLSearchParams({ correo: correo }),
        headers: { "Content-Type": "application/x-www-form-urlencoded" }
    })
    .then(response => {
        console.log('Response:', response); // Depuración para verificar la respuesta del servidor
        return response.json();
    })
    .then(data => {
        console.log('Data:', data); // Depuración para verificar el objeto JSON recibido
        document.getElementById("mensaje").innerText = data.message;
    })
    .catch(error => {
        console.error('Error:', error); // Captura de errores para depuración
        document.getElementById("mensaje").innerText = 'Error al recuperar la contraseña';
    });
});
</script>

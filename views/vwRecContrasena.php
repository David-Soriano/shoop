<div class="container bx-rec-con">
    <div class="row d-flex justify-content-center">
        <div class="rec-con col-5" id="bx-rec-corr">
            <h3>Recuperar Contraseña</h3>
            <form action="" class="d-flex flex-column" method="POST" id="recuperar-form">
                <label for="correo">Correo Electrónico</label>
                <input type="email" name="correo" id="correo" required
                    onkeyup="setupLeerCorreo('correo', 'span1-corr')">
                <p>Enviar código a: <span class="res-corr" id="span1-corr">No hay Correo</span></p>
                <button class="inp-link" id="btn-envcod" type="submit">
                    <span id="btn-text">Enviar</span>
                    <span id="btn-spinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                </button>
                <p id="timer-message" class="d-none">Reenviar en <span id="timer">60</span> segundos</p>
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
    let btn = document.getElementById("btn-envcod");
    let btnText = document.getElementById("btn-text");
    let btnSpinner = document.getElementById("btn-spinner");
    let timerMessage = document.getElementById("timer-message");
    let timerSpan = document.getElementById("timer");
    
    // Mostrar spinner y deshabilitar botón
    btn.disabled = true;
    btnText.classList.add("d-none");
    btnSpinner.classList.remove("d-none");

    fetch('../controller/recuperarController.php', {
        method: "POST",
        body: new URLSearchParams({ correo: correo }),
        headers: { "Content-Type": "application/x-www-form-urlencoded" }
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById("mensaje").innerText = data.message;
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById("mensaje").innerText = 'Error al recuperar la contraseña';
    })
    .finally(() => {
        // Detener spinner y cambiar texto del botón
        btnSpinner.classList.add("d-none");
        btnText.innerText = "Reenviar";
        timerMessage.classList.remove("d-none");
        
        let timeLeft = 60;
        let countdown = setInterval(() => {
            timeLeft--;
            timerSpan.innerText = timeLeft;
            if (timeLeft <= 0) {
                clearInterval(countdown);
                btn.disabled = false;
                btnText.innerText = "Enviar";
                timerMessage.classList.add("d-none");
            }
        }, 1000);
    });
});
</script>

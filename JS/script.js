function leerCorreo(id1, id2, id3) {
    let correo = document.getElementById(id1).value;
    document.getElementById(id2).innerHTML = correo;
    document.getElementById(id3).innerHTML = correo;
}
function ocultarBx() {
    let btnPrf = document.getElementById("btnPrf");
    let bandera = false;
    btnPrf.addEventListener('click', () => {
        if (bandera === false) {
            document.getElementById('bx-opc-prf').style.height = 'auto';
            bandera = true;
        } else {
            document.getElementById('bx-opc-prf').style.height = '0';
            bandera = false;
        }
    })
}

function insertText(text, id) {
    document.getElementById(id).innerHTML = text;
}

function verificarLogin() {
    let user = "grupoGIL";
    let pass = "sena";
    let inpUser = document.getElementById('inp-user');
    let inpPass = document.getElementById('inp-pass');
    document.getElementById('btn-ingresar').addEventListener('click', () => {
        if (inpUser.value == user && inpPass.value == pass) {
            alert("Bienvenido")
            window.location = "../home.php"
        } else {
            alert("Usuario o contraseña incorrectas")
            
        }
    })
}

window.addEventListener('load', verificarLogin)
window.addEventListener('load', ocultarBx)
window.addEventListener('load', ()=>{
    document.getElementById('btn-subreen').addEventListener('click', () =>{
        confirm("¿Seguro que desea reenviar el correo?")
    })
})
window.addEventListener('load', ()=>{
    document.getElementById('btn-logout').addEventListener('click', () =>{
        confirm("¿Seguro que desea cerrar la sesión?")
    })
})
window.addEventListener('load', function () {
    document.getElementById('pagar').addEventListener('click', () => {
        alert("Pago Confirmado");
    });
});
window.addEventListener("load", function () {
    document.getElementById('btn-add-carr').addEventListener('click', () => {
        alert("Producto Agregado");
    });
});
window.addEventListener('load', function () {
    document.getElementById('btn-registrar').addEventListener('click', () => {
        alert("Registrado con éxito");
    });
});

window.addEventListener('load', function () {
    new DataTable('#tpro');
});




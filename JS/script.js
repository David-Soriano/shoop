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

let btnReg = document.getElementById('btn-registrar');
let btnLog = document.getElementById('btn-log');
ocultarBx();

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
window.addEventListener("load", function () {
    document.getElementById("venpro").addEventListener("click", function () {
        alert("Producto subido exitosamente")
    })
    document.getElementById("btntrash").addEventListener("click", function () {
        confirm("¿Está seguro de querer eliminar el producto?")
    })
    document.getElementById("btnedit").addEventListener("click", function () {
        confirm("¿Está seguro de querer hacer cambios en el producto?")
    })
})

window.addEventListener('load', function () {
    new DataTable('#tpro');
});




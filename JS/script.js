function leerCorreo(id1, id2, id3) {
    let correo = document.getElementById(id1).value;
    document.getElementById(id2).innerHTML = correo;
    document.getElementById(id3).innerHTML = correo;
}

function ocultarBx() {
    let btnPrf = document.getElementById("btnPrf");
    let bandera = false;
    if (bandera == false) {
        btnPrf.addEventListener('click', () => {
            document.getElementById('bx-opc-prf').style.height = '16%';
            bandera = true;
            if (bandera == true) {
                btnPrf.addEventListener('click', () => {
                    document.getElementById('bx-opc-prf').style.height = '0';
                    bandera = false;
                    ocultarBx()
                })
            }
        })
    }
}

function insertText(text, id) {
    document.getElementById(id).innerHTML = text;
}

let btnReg = document.getElementById('btn-registrar');
let btnLog = document.getElementById('btn-log');
ocultarBx();
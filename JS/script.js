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
            document.getElementById('bx-opc-prf').style.display = 'block';
            bandera = true;
        } else {
            document.getElementById('bx-opc-prf').style.display = 'none';
            bandera = false;
        }
    })
}
document.addEventListener("DOMContentLoaded", function() {
    const cantidadInput = document.getElementById("cantidad");
    const maxCantidad = parseInt(cantidadInput.getAttribute("data-max"), 10);

    cantidadInput.addEventListener("input", function() {
        if (parseInt(cantidadInput.value, 10) > maxCantidad) {
            cantidadInput.value = maxCantidad; // Restringe al valor máximo si se excede
        }
    });
});
function changeMainImage(src) {
    // Obtener el elemento de la imagen principal
    const mainImage = document.getElementById("mainImage");
    // Cambiar la `src` de la imagen principal a la `src` recibida
    mainImage.src = src;
}

const mainImageContainer = document.querySelector('.image-zoom-container');
const mainImage = document.getElementById("mainImage");

mainImageContainer.addEventListener('mousemove', (event) => {
    const rect = mainImageContainer.getBoundingClientRect();
    const x = event.clientX - rect.left;
    const y = event.clientY - rect.top;

    // Calcula el movimiento de la imagen
    const xPercent = (x / rect.width) * 100;
    const yPercent = (y / rect.height) * 100;

    mainImage.style.transformOrigin = `${xPercent}% ${yPercent}%`;
});

mainImageContainer.addEventListener('mouseenter', () => {
    mainImageContainer.classList.add('zoom');
});

mainImageContainer.addEventListener('mouseleave', () => {
    mainImageContainer.classList.remove('zoom');
    mainImage.style.transformOrigin = 'center center'; // Reinicia la posición de zoom
});

function insertText(text, id) {
    document.getElementById(id).innerHTML = text;
}


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
// window.addEventListener('load', function () {
//     document.getElementById('btn-registrar').addEventListener('click', () => {
//         alert("Registrado con éxito");
//     });
// });

window.addEventListener('load', function () {
    new DataTable('#tpro');
});

// Asegúrate de que esto se ejecute cuando el DOM esté completamente cargado




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
//Responsive
window.addEventListener('resize', toggleContainerClass);

function toggleContainerClass() {
    const container = document.querySelector('.container, .container-fluid');  // Aseguramos que seleccionamos la clase correcta
    
    if (window.innerWidth <= 1300) {
        if (!container.classList.contains('container-fluid')) {
            container.classList.add('container-fluid');
            container.classList.remove('container');
        }
    } else {
        if (!container.classList.contains('container')) {
            container.classList.add('container');
            container.classList.remove('container-fluid');
        }
    }
}

// Llamamos a la función para asegurarnos de que se aplique cuando se carga la página
toggleContainerClass();

// Seleccionamos los botones de navegación y el contenedor
const btnLeft = document.getElementById("btn-left");
const btnRight = document.getElementById("btn-right");
const section = document.getElementById("product-section");

// Función para mover los productos a la izquierda
btnLeft.addEventListener("click", function() {
    section.scrollLeft -= 200; // Mueve 200px hacia la izquierda
});

// Función para mover los productos a la derecha
btnRight.addEventListener("click", function() {
    section.scrollLeft += 200; // Mueve 200px hacia la derecha
});

document.getElementById('search-input').addEventListener('input', function() {
    var query = this.value; // Obtener el valor del campo de búsqueda

    // Verificar que el valor sea lo suficientemente largo para realizar la búsqueda
    if (query.length > 2) {
        fetch('controller/buscar.php?query=' + encodeURIComponent(query)) // Enviar solicitud GET a buscar.php
            .then(response => response.text()) // Procesar la respuesta como texto
            .then(data => {
                document.getElementById('search-results').innerHTML = data; // Mostrar los resultados
            })
            .catch(error => console.error('Error al buscar:', error)); // Manejar posibles errores
    } else {
        document.getElementById('search-results').innerHTML = ''; // Limpiar los resultados si no hay texto o si es muy corto
    }
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




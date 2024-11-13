// ======= Declaraciones globales =======
// Aquí puedes agregar configuraciones generales, constantes o variables globales si las necesitas.

// ======= Funciones relacionadas con búsquedas =======
function setupSearch() {
    const searchInput = document.getElementById('search-input');
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            const query = this.value;
            if (query.length > 2) {
                fetch('controller/buscar.php?query=' + encodeURIComponent(query))
                    .then(response => response.text())
                    .then(data => {
                        const searchResults = document.getElementById('search-results');
                        if (searchResults) {
                            searchResults.innerHTML = data;
                        }
                    })
                    .catch(error => console.error('Error al buscar:', error));
            } else {
                const searchResults = document.getElementById('search-results');
                if (searchResults) {
                    searchResults.innerHTML = '';
                }
            }
        });
    }
}

// ======= Funciones relacionadas con el zoom de imágenes =======
function setupZoom() {
    const mainImageContainer = document.querySelector('.image-zoom-container');
    if (mainImageContainer) {
        const mainImage = document.getElementById("mainImage");
        if (mainImage) {
            mainImageContainer.addEventListener('mousemove', (event) => {
                const rect = mainImageContainer.getBoundingClientRect();
                const x = event.clientX - rect.left;
                const y = event.clientY - rect.top;
                const xPercent = (x / rect.width) * 100;
                const yPercent = (y / rect.height) * 100;
                mainImage.style.transformOrigin = `${xPercent}% ${yPercent}%`;
            });

            mainImageContainer.addEventListener('mouseenter', () => {
                mainImageContainer.classList.add('zoom');
            });

            mainImageContainer.addEventListener('mouseleave', () => {
                mainImageContainer.classList.remove('zoom');
                mainImage.style.transformOrigin = 'center center';
            });
        }
    }
}

// ======= Funciones relacionadas con cambio de imagenes =======
function changeMainImage(src) {
    // Obtener el elemento de la imagen principal
    const mainImage = document.getElementById("mainImage");
    // Cambiar la src de la imagen principal a la src recibida
    mainImage.src = src;
}

// ======= Funciones relacionadas con botones =======
function setupButtons() {
    const btnLogout = document.getElementById('btn-logout');
    if (btnLogout) {
        btnLogout.addEventListener('click', () => {
            confirm("¿Seguro que desea cerrar la sesión?");
        });
    }

    const btnAddCarr = document.getElementById('btn-add-carr');
    if (btnAddCarr) {
        btnAddCarr.addEventListener('click', () => {
            alert("Producto Agregado");
        });
    }

    const btnPagar = document.getElementById('pagar');
    if (btnPagar) {
        btnPagar.addEventListener('click', () => {
            alert("Pago Confirmado");
        });
    }

    const btnSubReen = document.getElementById('btn-subreen');
    if (btnSubReen) {
        btnSubReen.addEventListener('click', () => {
            confirm("¿Seguro que desea reenviar el correo?");
        });
    }
}

// ======= Funciones relacionadas con contenedores responsivos =======
function setupResponsiveContainer() {
    function toggleContainerClass() {
        const container = document.querySelector('.container, .container-fluid');
        if (container) {
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
    }

    window.addEventListener('resize', toggleContainerClass);
    toggleContainerClass(); // Llama a la función inicialmente
}

// ======= Funciones relacionadas con la navegación de productos =======
function setupProductNavigation() {
    const btnLeft = document.getElementById("btn-left");
    const btnRight = document.getElementById("btn-right");
    const section = document.getElementById("product-section");

    if (btnLeft && btnRight && section) {
        section.scrollLeft = 0; // Inicia desde el primer elemento

        btnLeft.addEventListener("click", function () {
            section.scrollLeft -= section.clientWidth / 2; // Desplaza a la izquierda
        });

        btnRight.addEventListener("click", function () {
            section.scrollLeft += section.clientWidth / 2; // Desplaza a la derecha
        });
    }
}

// ======= Funciones relacionadas con cantidad máxima =======
function setupMaxQuantity() {
    const cantidadInput = document.getElementById("cantidad");
    if (cantidadInput) {
        const maxCantidad = parseInt(cantidadInput.getAttribute("data-max"), 10);
        cantidadInput.addEventListener("input", function () {
            if (parseInt(cantidadInput.value, 10) > maxCantidad) {
                cantidadInput.value = maxCantidad; // Restringe al valor máximo si se excede
            }
        });
    }
}

// ======= Función para ocultar y mostrar box de opciones =======
function setupBoxToggle() {
    const btnPrf = document.getElementById("btnPrf");
    const boxOpcPrf = document.getElementById('bx-opc-prf');
    if (btnPrf && boxOpcPrf) {
        let bandera = false;
        btnPrf.addEventListener('click', () => {
            if (bandera === false) {
                boxOpcPrf.style.display = 'block';
                bandera = true;
            } else {
                boxOpcPrf.style.display = 'none';
                bandera = false;
            }
        });
    }
}

// ======= Inicializar DataTable =======
function setupDataTable() {
    if (document.querySelector('#tpro')) {
        new DataTable('#tpro');
    }
}

// ======= Función para leer y mostrar correos =======
function setupLeerCorreo(id1, id2, id3) {
    const correo = document.getElementById(id1)?.value;
    if (correo) {
        document.getElementById(id2).innerHTML = correo;
        document.getElementById(id3).innerHTML = correo;
    }
}

function setupInputSearch() {
    // Detecta si el input tiene contenido
    const input = document.getElementById('search-input');

    input.addEventListener('input', function () {
        if (input.value.length > 0) {
            input.classList.add('has-content');  // Añadir clase cuando hay contenido
        } else {
            input.classList.remove('has-content');  // Eliminar clase si está vacío
        }
    });

}
// ======= Cargar todas las configuraciones al inicio =======
window.addEventListener('load', () => {
    setupSearch();
    setupZoom();
    setupButtons();
    setupResponsiveContainer();
    setupProductNavigation();
    setupMaxQuantity();
    setupBoxToggle();
    setupDataTable();
    setupInputSearch();
});

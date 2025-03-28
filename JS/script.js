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
    const cantidadInputs = document.querySelectorAll(".inp-cantidad-prd");

    cantidadInputs.forEach(input => {
        const maxCantidad = parseInt(input.getAttribute("data-max"), 10);

        input.addEventListener("input", function () {
            if (parseInt(input.value, 10) > maxCantidad) {
                input.value = maxCantidad; // Restringe al valor máximo si se excede
            }
        });
    });
}
// ======= Función para ocultar y mostrar box de opciones =======
function setupBoxToggle() {
    const btnPrf = document.getElementById("btnPrf");
    const boxOpcPrf = document.getElementById('bx-opc-prf');
    boxOpcPrf.style.display = "none";
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
function setupLeerCorreo(id1, id2) {
    const correo = document.getElementById(id1).value;
    if (correo) {
        document.getElementById(id2).innerHTML = correo;
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

document.querySelectorAll('.btn-buy').forEach(button => {
    button.addEventListener('click', function () {
        const cantidadInput = this.parentElement.querySelector('#cantidad');
        const cantidad = cantidadInput ? parseInt(cantidadInput.value) : 1;

        const producto = {
            id: this.getAttribute('data-id'),
            nombre: this.getAttribute('data-nombre'),
            precio: this.getAttribute('data-precio'),
            cantidad: cantidad,
            imagen: this.getAttribute('data-imagen')
        };
        fetch('controller/resPago.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(producto)
        })
            .then(response => response.json())
            .then(data => {
                if (!data.status === 'success') {
                    alert('Error al añadir el producto');
                }
            })
            .catch(error => console.error('Error:', error));
    });
});

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', () => {
            const idpro = button.dataset.idpro;
            const idusu = button.dataset.idusu;
            const precio = button.dataset.precio;

            // Si no hay un usuario logueado, asignar evento para redirigir al login

            if (!idusu) {
                button.addEventListener("click", () => {
                    Swal.fire({
                        title: "Inicia sesión",
                        text: "Debes iniciar sesión para agregar productos al carrito.",
                        confirmButtonText: "Iniciar Sesión",
                        confirmButtonColor: "#3085d6",
                        showCancelButton: true,
                        cancelButtonText: "Cancelar",
                        cancelButtonColor: "#d33",
                        customClass: {
                            popup: 'custom-popup',
                            title: 'custom-title',
                            confirmButton: 'custom-confirm-button',
                            cancelButton: 'custom-cancel-button'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "views/vwLogin.php";
                        }
                    });
                });
                return;
            }

            // Obtener la cantidad actual del input asociado
            const inputCantidad = document.getElementById("cantidad");
            const cantidad = inputCantidad ? inputCantidad.value : 1;

            fetch('controller/ccarr.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    idpro,
                    idusu,
                    precio,
                    cantidad
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) { // Asegúrate de que el servidor envía "success: true" en la respuesta
                        let btn = document.getElementById("btn-add-carr");
                        if (button) {
                            button.style.backgroundColor = "#00a650"; // Cambiar color a verde
                            button.innerHTML = '<i class="bi bi-cart-check" style="color: #FFF"></i>'; // Cambiar icono
                        }
                    }
                })
                .catch(error => console.error('Error:', error));

        });
    });
});


document.querySelectorAll(".bx-ico-favo i").forEach(async icon => {
    const idusu = icon.getAttribute("data-idusu");
    const idpro = icon.getAttribute("data-idpro");

    // Si no hay un usuario logueado, asignar evento para redirigir al login
    if (!idusu) {
        icon.addEventListener("click", () => {
            Swal.fire({
                title: "Inicia sesión",
                text: "Debes iniciar sesión para guardar tus favoritos.",
                confirmButtonText: "Iniciar Sesión",
                confirmButtonColor: "#3085d6",
                showCancelButton: true,
                cancelButtonText: "Cancelar",
                cancelButtonColor: "#d33",
                customClass: {
                    popup: 'custom-popup',
                    title: 'custom-title',
                    confirmButton: 'custom-confirm-button',
                    cancelButton: 'custom-cancel-button'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "views/vwLogin.php";
                }
            });
        });
        return;
    }


    try {
        let response = await fetch("controller/cfav.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `idusu=${idusu}&idpro=${idpro}&accion=verificar`
        });

        let responseText = await response.text();
        let data = JSON.parse(responseText);

        if (data.success) {
            if (data.isFavorite) {
                icon.classList.add("bi-heart-fill");
                icon.classList.remove("bi-heart");
            } else {
                icon.classList.add("bi-heart");
                icon.classList.remove("bi-heart-fill");
            }
        } else {
            alert("Hubo un error al verificar el estado del favorito.");
        }
    } catch (error) {
        console.error("Error al verificar si el producto está en favoritos:", error);
    }

    // Manejador de evento de clic para alternar entre favoritos
    icon.addEventListener("click", async function () {
        let accion = this.classList.contains("bi-heart-fill") ? "eliminar" : "agregar";

        try {
            let response = await fetch("controller/cfav.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `idusu=${idusu}&idpro=${idpro}&accion=${accion}`
            });
            let data = await response.json();

            if (data.success) {
                this.classList.toggle("bi-heart-fill", accion === "agregar");
                this.classList.toggle("bi-heart", accion === "eliminar");
            } else {
                alert("Error: " + (data.error || "No se pudo actualizar"));
            }
        } catch (error) {
            console.error("Error en la solicitud:", error);
        }
    });
});


window.addEventListener('load', () => {
    document.querySelectorAll('.bx-favor-elim').forEach(btn => {
        btn.addEventListener('click', async function () {
            let idusu = this.getAttribute('data-idusu');
            let idpro = this.getAttribute('data-idpro');

            if (!idusu || !idpro) {
                console.error("ID de usuario o producto no encontrados.");
                return;
            }

            try {
                let response = await fetch('controller/cfav.php', {
                    method: 'POST',
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: `idusu=${idusu}&idpro=${idpro}&accion=eliminar`
                });

                let data = await response.json();

                if (data.success) {
                    location.reload();
                } else {
                    console.error('Error al eliminar el favorito:', data.error || 'No se pudo eliminar.');
                }

            } catch (error) {
                console.error('Error en la solicitud:', error);
            }
        });
    });
});

document.addEventListener("DOMContentLoaded", () => {
    // Obtener el input de cantidad y el botón de agregar al carrito
    const cantidadInput = document.getElementById("cantidad");
    const btnAddCart = document.getElementById("btn-add-carr");

    if (cantidadInput && btnAddCart) {
        // Actualizar el data-cantidad cuando cambie la cantidad
        cantidadInput.addEventListener("input", () => {
            let cantidad = cantidadInput.value;
            let maxCantidad = cantidadInput.getAttribute("data-max");

            // Asegurar que la cantidad no supere el stock disponible
            if (cantidad > maxCantidad) {
                cantidadInput.value = maxCantidad;
                cantidad = maxCantidad;
            } else if (cantidad < 1) {
                cantidadInput.value = 1;
                cantidad = 1;
            }

            // Asignar la cantidad al atributo data-cantidad del botón
            btnAddCart.setAttribute("data-cantidad", cantidad);
        });
    }
    let formPago = document.getElementById("formPago");
    if (formPago) {
        formPago.addEventListener("submit", async function (event) {
            event.preventDefault(); // Evita el envío automático

            let productos = [];
            document.querySelectorAll(".producto-carrito").forEach(item => {
                productos.push({
                    id: item.dataset.idpro,
                    nombre: item.dataset.nombre,
                    cantidad: item.dataset.cantidad,
                    precio: item.dataset.precio,
                    imagen: item.dataset.imagen // Asegúrate de tener este atributo en el HTML
                });
            });

            try {
                let response = await fetch("controller/resPago.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify(productos)
                });

                let data = await response.json();

                if (data.status === "success") {
                    window.location.href = "home.php?pg=9"; // Redirige a la página de pago
                } else {
                    alert(data.message);
                }
            } catch (error) {
                console.error("Error en la solicitud:", error);
            }
        });
    }

    document.querySelectorAll('.btn-eli-pcar').forEach(boton => {
        boton.addEventListener('click', function (event) {
            event.preventDefault();

            const idProducto = this.getAttribute('data-idpro');

            fetch('controller/ccarr.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ idpro: idProducto, acc: "eli" })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    });


});
function cargarContenido(url) {

    // Ocultar el menú
    $(".bx-conf-pef").hide();

    $.ajax({
        url: url,
        type: "GET",
        beforeSend: function () {
            $("#contenido").html("<p>Cargando...</p>");
        },
        success: function (data) {
            // Agregar botón de volver dentro del contenido cargado
            let botonVolver = '<button onclick="volverMenu()" class="btn btn-vol-pf"><i class="bi bi-arrow-bar-left"></i> Volver</button>';

            $("#contenido").html(botonVolver + data);
        },
        error: function (xhr, status, error) {
            $("#contenido").html("<p>Error al cargar el contenido.</p>");
        }
    });
}
function volverMenu() {
    $("#contenido").html("");
    $(".bx-conf-pef").show();
}
if (document.getElementById('depart')) {
    $(document).ready(function () {
        $("#depart").change(function () {
            var departamentoID = $(this).val();
            if (departamentoID != "") {
                $.ajax({
                    url: "../controller/cubi.php",
                    type: "POST",
                    data: { idubi: departamentoID },
                    dataType: "json",
                    success: function (data) {
                        var opciones = '<option value="">Seleccione</option>';
                        $.each(data, function (index, ciudad) {
                            opciones += '<option value="' + ciudad.idubi + '">' + ciudad.nomubi + '</option>';
                        });
                        $("#ciudad").html(opciones);
                    }
                });
            } else {
                $("#ciudad").html('<option value="">Seleccione un departamento primero</option>');
            }
        });
    });

}
function desplegarMenu() {
    let mainItems = document.querySelectorAll('.nav-item');

    mainItems.forEach((item) => {
        let submenu = item.querySelector('.men-vrt'); // Buscar el submenú dentro del nav-item

        item.addEventListener('click', (event) => {
            event.stopPropagation(); // Evitar que el evento de document lo cierre inmediatamente

            // Cerrar otros submenús antes de abrir el actual
            document.querySelectorAll('.men-vrt').forEach(menu => {
                if (menu !== submenu) menu.style.display = 'none';
            });

            // Alternar la visibilidad del submenú correspondiente
            if (submenu) {
                submenu.style.display = submenu.style.display === 'block' ? 'none' : 'block';
            }
        });
    });

    // Ocultar todos los submenús al hacer clic fuera de ellos
    document.addEventListener('click', () => {
        document.querySelectorAll('.men-vrt').forEach(menu => menu.style.display = 'none');
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
    desplegarMenu();
});
window.addEventListener('load', () => {
    setupInputSearch();
});

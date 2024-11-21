function calcularPrecio() {
    const valorUnitario = parseFloat(document.getElementById('valorunitario').value) || 0;
    const descuentoPorcentaje = parseFloat(document.getElementById('pordescu').value) || 0; // Descuento en porcentaje
    const iva = 0.19; // 19% IVA
    const aplicacion = 0.07; // 7% para el aplicativo

    // Cálculo del descuento
    const descuento = (valorUnitario * descuentoPorcentaje) / 100;

    // Cálculo del precio final
    let precio = valorUnitario + (valorUnitario * iva) + (valorUnitario * aplicacion) - descuento;

    // Mostrar precio en el input
    document.getElementById('precio').value = precio.toFixed(2);

    // Mostrar desglose con formato
    if (isNaN(valorUnitario) || valorUnitario < 0) {
        document.getElementById('detalle').innerHTML = "<strong>Ingresa el valor unitario</strong>";
        document.getElementById('precio').value = ""; // Limpiar el campo de precio
        return; // Salir de la función
    }
    const desglose = `
        <b>Valor Unitario:</b> $${valorUnitario.toLocaleString('es-CO', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}<br>
        <b>IVA (19%):</b> $${(valorUnitario * iva).toLocaleString('es-CO', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}<br>
        <b>Comisión Aplicativo (7%):</b> $${(valorUnitario * aplicacion).toLocaleString('es-CO', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}<br>
        <b>Descuento (${descuentoPorcentaje}%):</b> -$${descuento.toLocaleString('es-CO', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}<br>
        <strong>Precio Final: $${precio.toLocaleString('es-CO', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</strong>
    `;
    document.getElementById('detalle').innerHTML = desglose;
}
let selectedFiles = [];
function actualizarOrden() {
    const input = document.getElementById('imgpro');
    const ordenContenedor = document.getElementById('orden-imagenes');
    const files = input.files;

    // Añadir las nuevas imágenes seleccionadas al array
    for (let i = 0; i < files.length; i++) {
        if (!selectedFiles.includes(files[i])) {
            selectedFiles.push(files[i]);  // Añadir archivo al array si no está ya
        }
    }

    // Limpiar el contenedor antes de agregar las nuevas imágenes
    ordenContenedor.innerHTML = "";

    // Mostrar todas las imágenes en selectedFiles (nuevas y antiguas)
    selectedFiles.forEach((archivo, index) => {
        const reader = new FileReader();

        reader.onload = (e) => {
            const imgDiv = document.createElement('div');
            imgDiv.classList.add('col', 'imagen-preview');

            imgDiv.innerHTML = `
                <img src="${e.target.result}" alt="Imagen ${index + 1}" class="img-thumbnail" style="max-width: 100px; margin: 5px;">
                <label>
                    <input type="radio" name="imagenPrincipal" value="${index}" ${index === 0 ? "checked" : ""}>
                    Principal
                </label>
                <button type="button" onclick="eliminarImagen(${index})" class="btn-del"><i class="bi bi-x-circle-fill"></i></button>
            `;
            ordenContenedor.appendChild(imgDiv);
        };

        reader.readAsDataURL(archivo);
    });
}
function eliminarImagen(index) {
    // Eliminar la imagen del array
    selectedFiles.splice(index, 1);

    // Limpiar el input file
    const input = document.getElementById('imgpro');
    input.value = '';  // Vaciar el campo input de tipo file

    // Reasignar los archivos restantes al input
    for (let i = 0; i < selectedFiles.length; i++) {
        let dataTransfer = new DataTransfer();
        dataTransfer.items.add(selectedFiles[i]); // Agregar el archivo al DataTransfer
        input.files = dataTransfer.files; // Asignar el nuevo array de archivos
    }

    // Volver a actualizar la vista
    actualizarOrden();
}
function nextStep(step) {
    // Ocultar todos los pasos
    for (let i = 1; i <= 4; i++) {
        document.getElementById('step' + i).style.display = 'none';
    }
    // Mostrar el paso actual
    document.getElementById('step' + step).style.display = 'block';
}
function cantCr() {
    let cant = document.getElementById('cantcr').value; // Cantidad de inputs a generar
    let bx = document.getElementById('descar');        // Contenedor para los inputs
    bx.innerHTML = ""; // Limpiar el contenido antes de agregar los nuevos inputs

    for (let i = 0; i < cant; i++) {
        bx.innerHTML += `<input type="text" name="descripcioncr[]" id="" placeholder="Característica ${i + 1}"><br>`;
    }
}
// Función principal
function mostrarFechaFin() {
    const descuento = document.getElementById('pordescu').value;
    const fechaOferta = document.getElementById('fechaOferta');
    const fechaInicio = document.getElementById('fechaInicio');
    const fechaFin = document.getElementById('fechaFin');

    if (descuento > 0) {
        fechaOferta.style.display = "block";

        // Obtener la fecha actual desde la API y configurar los valores
        obtenerFechaActual((fechaActual) => {
            fechaInicio.value = fechaActual; // Establecer la fecha actual en fechaInicio
            fechaFin.min = fechaActual; // Configurar la fecha mínima permitida en fechaFin
            fechaFin.value = fechaActual;
        });
    } else {
        fechaOferta.style.display = "none";
        fechaInicio.value = ""; // Limpiar la fecha de inicio si no hay descuento
        fechaFin.value = ""; // Limpiar el campo de fecha fin
    }
}

// Función para obtener la fecha desde Time Zone DB
async function obtenerFechaActual(callback) {
    const apiKey = '554XT8S07RF7';
    const timezone = 'America/Bogota';
    const response = await fetch(`https://api.timezonedb.com/v2.1/get-time-zone?key=${apiKey}&format=json&by=zone&zone=${timezone}`);
    const data = await response.json();

    if (data && data.formatted) {
        const fechaActual = ajustarZonaHoraria(data.formatted);
        callback(fechaActual);
    } else {
        console.error('Error al obtener la fecha actual de la API');
    }
}

// Ajustar la fecha a la zona horaria local y retornar en formato YYYY-MM-DD
function ajustarZonaHoraria(fechaISO) {
    const fecha = new Date(fechaISO);
    const offsetMilisegundos = fecha.getTimezoneOffset() * 60 * 1000; // Compensar la diferencia horaria
    const fechaLocal = new Date(fecha.getTime() - offsetMilisegundos);
    return fechaLocal.toISOString().split('T')[0]; // Retornar en formato YYYY-MM-DD
}

function actualizarTabla() {
    let searchTerm = $('#search').val();  // Obtener el valor del campo de búsqueda

    console.log("Buscando:", searchTerm);  // Verifica el valor de búsqueda

    // Realizar la solicitud AJAX
    $.ajax({
        url: '../controller/buscTable.php',  // Ruta correcta del archivo PHP que procesa la búsqueda
        method: 'GET',
        data: {
            search: searchTerm,
            vw: '002'  // Agregar el parámetro vw=002
        },
        success: function (response) {
            console.log(response);  // Verifica la respuesta del servidor
            $('#productTable tbody').html(response);
        },
        error: function (xhr, status, error) {
            console.error("Error en la solicitud AJAX: ", error);
        }
    });
}

function buttonsTable() {
    const checkboxes = document.querySelectorAll('.product-checkbox');
    const editButton = document.getElementById('editButton');
    const deleteButton = document.getElementById('deleteButton');
    // Verificar cambios en los checkboxes
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', () => {
            // Habilitar los botones si hay al menos un checkbox seleccionado
            const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
            editButton.disabled = !anyChecked;
            deleteButton.disabled = !anyChecked;
        });
    });

    // Acción al hacer clic en "Editar seleccionados"
    editButton.addEventListener('click', () => {
        const selectedIds = Array.from(checkboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.value);

        if (selectedIds.length === 0) {
            alert("Selecciona al menos un producto para editar.");
            return;
        }

        // Por simplicidad, consideramos que solo puedes editar un producto a la vez
        if (selectedIds.length > 1) {
            alert("Por favor, selecciona solo un producto para editar.");
            return;
        }

        const productId = selectedIds[0];

        // Simulación de obtener datos del producto
        // Esto debería ser una solicitud AJAX para obtener los datos del producto desde el servidor
        const productData = {
            nompro: "Producto de Ejemplo",
            precio: 1200,
            cantidad: 10,
            fechfinofer: "2024-12-31",
            pordescu: 5,
            nomval: "Tecnología",
            imgpro: "https://via.placeholder.com/150"
        };

        // Crear modal dinámicamente
        const modalHTML = ``;

        // Insertar el modal en el cuerpo del documento
        document.body.insertAdjacentHTML('beforeend', modalHTML);

        // Mostrar el modal
        document.getElementById('popup').style.display = 'flex';
    });

    function closeModal() {
        const popup = document.getElementById('popup');
        if (popup) popup.remove();
    }

    function saveProductData() {
        // Aquí puedes procesar y enviar los datos del formulario al backend
        const formData = {
            nompro: document.getElementById('nompro').value,
            precio: document.getElementById('precio').value,
            cantidad: document.getElementById('cantidad').value,
            fechfinofer: document.getElementById('fechfinofer').value,
            pordescu: document.getElementById('pordescu').value,
            nomval: document.getElementById('nomval').value,
        };

        console.log("Datos del formulario guardados:", formData);

        // Simulación de guardar los datos (debería enviarse al backend)
        closeModal();
        alert("Producto guardado exitosamente.");
    }


    // Acción al hacer clic en "Eliminar seleccionados"
    deleteButton.addEventListener('click', () => {
        const selectedIds = Array.from(checkboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.value);

        if (confirm(`¿Estás seguro de que deseas eliminar los productos seleccionados?`)) {
            // Enviar solicitud AJAX para eliminar los productos
            fetch('../controller/cpancon.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ action: 'delete', ids: selectedIds })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Productos eliminados exitosamente');
                        location.reload(); // Recargar la página
                    } else {
                        alert('Error al eliminar los productos');
                    }
                });
        }
    });
}
document.addEventListener('DOMContentLoaded', function () {
    buttonsTable();
});
window.addEventListener('load', () => {
    document.getElementById('valorunitario').addEventListener('input', calcularPrecio);
    document.getElementById('pordescu').addEventListener('input', calcularPrecio);
});


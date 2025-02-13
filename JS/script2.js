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
function eliminarImagen(index, existente = false) {
    if (existente) {
        // Contenedor de imágenes existentes
        const imageExistContainer = document.getElementById('image_exist');
        const imgDivs = imageExistContainer.querySelectorAll('.imagen-preview'); // Obtener imágenes existentes

        // Verificar si el índice es válido
        if (!imgDivs[index]) {
            console.error("No se encontró la imagen existente correspondiente en el DOM.");
            return;
        }

        // Eliminar el input oculto correspondiente
        const hiddenInputs = document.querySelectorAll('input[name="imagenesExistentes[]"]');
        if (hiddenInputs[index]) {
            hiddenInputs[index].remove(); // Elimina el input oculto si existe
        }

        // Eliminar el contenedor visual de la imagen
        imgDivs[index].remove();
    } else {
        // Contenedor de imágenes nuevas
        const imageNewContainer = document.getElementById('orden-imagenes');
        const imgDivs = imageNewContainer.querySelectorAll('.imagen-preview'); // Obtener imágenes nuevas

        // Verificar si el índice es válido
        if (!imgDivs[index]) {
            console.error("No se encontró la imagen nueva correspondiente en el DOM.");
            return;
        }

        // Eliminar la imagen nueva del array
        selectedFiles.splice(index, 1);

        // Actualizar el input file
        const input = document.getElementById('imgpro');
        const dataTransfer = new DataTransfer();
        selectedFiles.forEach(file => dataTransfer.items.add(file)); // Agregar las imágenes restantes
        input.files = dataTransfer.files; // Actualizar el input file

        // Eliminar el contenedor visual de la imagen
        imgDivs[index].remove();
    }

    // Actualizar la vista del orden
    actualizarOrden();
}



function nextStep(step) {
    // Ocultar todos los pasos
    for (let i = 1; i <= 4; i++) {
        document.getElementById('step' + i).style.display = 'none';
    }
    // Mostrar el paso actual
    document.getElementById('step' + step).style.display = 'flex';
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

function actualizarTablaGenerica(url) {
    let searchTerm = $('#search').val(); // Obtener el valor del campo de búsqueda

    // Realizar la solicitud AJAX
    $.ajax({
        url: url,
        method: 'GET',
        data: {
            search: searchTerm,
            vw: '002'
        },
        success: function (response) {
            $('#productTable tbody').html(response); // Actualizar la tabla con la respuesta
        },
        error: function (xhr, status, error) {
            console.error("Error en la solicitud AJAX: ", error);
        }
    });
}

// Llamadas específicas
function actualizarTabla() {
    actualizarTablaGenerica('../controller/buscTable.php');
}

function actualizarTabla2() {
    actualizarTablaGenerica('../controller/buscTb2.php');
}

function actualizarTabla3() {
    actualizarTablaGenerica('../controller/buscTb3.php');
}
function actualizarTabla4() {
    actualizarTablaGenerica('../controller/buscTb4.php');
}
function buttonsTable() {
    document.getElementById('editButton').addEventListener('click', function () {
        const selectedIds = getSelectedProductIds(); // Captura los IDs seleccionados
        console.log(selectedIds);
        if (selectedIds.length > 0) {
            const idProParam = selectedIds.join(',');  // Convierte los IDs a una cadena separada por comas
            fetchProductData('idpro', idProParam); // Pasa la cadena como parámetro
            const modalElement = new bootstrap.Modal(document.getElementById('exampleModal'));
            modalElement.show();
        } else {
            alert("Selecciona al menos un producto para editar.");
        }
    });
    document.getElementById('deleteButton').addEventListener('click', function () {
        const selectedIds = getSelectedProductIds(); // Captura los IDs seleccionados
        if (selectedIds.length > 0) {
            if (confirm('¿Estás seguro de que deseas eliminar los productos seleccionados?')) {
                const idProParam = selectedIds.join(','); // Convertir los IDs en una cadena separada por comas
                deleteProductData(idProParam); // Llamar a la función de eliminación
            }
        } else {
            alert("Selecciona al menos un producto para eliminar.");
        }
    });
}
function buttonsTablePedidos() {
    document.getElementById('editButton2').addEventListener('click', function () {
        const selectedIds = getSelectedProductIds(); // Captura los IDs seleccionados
        if (selectedIds.length > 0) {
            const idProParam = selectedIds.join(',');  // Convierte los IDs a una cadena separada por comas
            fetchProductData('idped', idProParam); // Pasa la cadena como parámetro
            const modalElement = new bootstrap.Modal(document.getElementById('exampleModal'));
            modalElement.show();
        } else {
            alert("Selecciona al menos un pedido para editar.");
        }
    });
    document.getElementById('deleteButton2').addEventListener('click', function () {
        const selectedIds = getSelectedProductIds(); // Captura los IDs seleccionados
        if (selectedIds.length > 0) {
            if (confirm('¿Desea cancelar este pedido?')) {
                const idProParam = selectedIds.join(','); // Convertir los IDs en una cadena separada por comas
                cancelPedData(idProParam); // Llamar a la función de eliminación
            }
        } else {
            alert("Selecciona al menos un producto para eliminar.");
        }
    });
}
function deleteProductData(idpro) {

    fetch(`../controller/edit.php`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ idpro }), // Enviar como JSON
    })
        .then(async response => {
            const rawText = await response.text();
            if (!response.ok) {
                throw new Error('Error en la respuesta: ' + response.status);
            }
            return rawText ? JSON.parse(rawText) : {};
        })
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('No se pudieron eliminar los productos: ' + data.error);
            }
        })
        .catch(error => {
            console.error('Hubo un problema con la solicitud:', error);
        });
}
function cancelPedData(idped) {
    console.log("Enviando idped:", idped); // Verifica el valor antes de enviarlo

    fetch(`../controller/cped.php`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ idped }), // Enviar como JSON
    })
        .then(async response => {
            const rawText = await response.text();
            console.log("Respuesta sin procesar:", rawText); // Verificar lo que devuelve el servidor

            if (!response.ok) {
                throw new Error('Error en la respuesta: ' + response.status);
            }
            return rawText ? JSON.parse(rawText) : {};
        })
        .then(data => {
            console.log("Respuesta procesada:", data); // Verifica la respuesta JSON

            if (data.success) {
                location.reload();
            } else {
                alert('No se pudo cancelar el pedido: ' + data.error);
            }
        })
        .catch(error => {
            console.error('Hubo un problema con la solicitud:', error);
        });
}


// Función que obtiene los IDs de los productos seleccionados
function getSelectedProductIds() {
    const selectedCheckboxes = document.querySelectorAll('.product-checkbox:checked');
    const ids = [];
    selectedCheckboxes.forEach(checkbox => {
        ids.push(checkbox.value);
    });
    return ids;
}

// Función que maneja la solicitud de datos del producto
function fetchProductData(param, id) {
    fetch(`../controller/edit.php?${encodeURIComponent(param)}=${encodeURIComponent(id)}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Error en la respuesta: ${response.status} ${response.statusText}`);
            }
            return response.json();
        })
        .then(data => {
            if (data) {
                populateModal(data);
            } else {
                console.error('Los datos recibidos están vacíos.');
            }
        })
        .catch(error => {
            console.error('Hubo un problema con la solicitud:', error);
        });
}


// Función que llena el modal con los datos obtenidos
function populateModal(data) {
    if (data && Array.isArray(data) && data.length > 0) {
        const product = data[0]; // Tomar el primer producto
        // Llenar los campos del formulario con los datos
        const estadoPedido = product.estped;

        // Seleccionar el input correspondiente
        document.querySelectorAll('input[name="estped"]').forEach(radio => {
            if (estadoPedido == 'Cancelado') {
                radio.disabled = true;
                document.querySelector('.bx-st-ped_st').innerHTML = "Los pedidos CANCELADOS no se pueden actualizar.";
            } else if (radio.value === estadoPedido) {
                radio.checked = true;
            }
        });

        // Verificar si el elemento 'exampleModalLabel' existe antes de actualizarlo
        const modalLabel = document.getElementById('exampleModalLabel');
        if (modalLabel) {
            modalLabel.innerHTML = product.nompro;
        }

        // Verificar si el input 'idped' existe antes de actualizarlo
        const idpedInput = document.querySelector('[name="idped2"]');
        if (idpedInput) {
            idpedInput.value = product.idped;
        }
        // Verificar si el input 'nompro' existe antes de actualizarlo
        const nomproInput = document.querySelector('[name="nompro"]');
        if (nomproInput) {
            nomproInput.value = product.nompro;
        }

        // Verificar si el input 'descripcion' existe antes de actualizarlo
        const descripcionInput = document.querySelector('[name="descripcion"]');
        if (descripcionInput) {
            descripcionInput.value = product.descripcion;
        }

        // Verificar si el input 'cantidad' existe antes de actualizarlo
        const cantidadInput = document.querySelector('[name="cantidad"]');
        if (cantidadInput) {
            cantidadInput.value = product.cantidad;
        }

        // Repetir este patrón para otros campos...

        // Llenar las características
        const caracteristicasContainer = document.getElementById('descar');
        if (caracteristicasContainer) {
            caracteristicasContainer.innerHTML = ''; // Limpiar el contenedor
            if (product.caracteristicas) {
                product.caracteristicas.forEach((caracteristica, index) => {
                    const caracteristicaDiv = document.createElement('div');
                    caracteristicaDiv.classList.add('row');
                    caracteristicaDiv.innerHTML = `
                        <div class="col">
                            <input type="text" name="caracteristica_${index}" value="${caracteristica.descripcioncr}" placeholder="Característica ${index + 1}">
                        </div>
                    `;
                    caracteristicasContainer.appendChild(caracteristicaDiv);
                });
            }
        }

        // Llenar las imágenes
        const imageExistContainer = document.getElementById('image_exist');
        if (imageExistContainer) {
            imageExistContainer.innerHTML = ""; // Limpiar cualquier contenido previo
            if (product.imagenes) {
                product.imagenes.forEach((imagen, index) => {
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'imagenesExistentes[]';
                    hiddenInput.value = imagen.imgpro;
                    imageExistContainer.appendChild(hiddenInput);

                    const imgDiv = document.createElement('div');
                    imgDiv.classList.add('col', 'imagen-preview');
                    imgDiv.setAttribute('data-index', index);
                    imgDiv.innerHTML = `
                        <img src="../${imagen.imgpro}" alt="Imagen ${index + 1}" class="img-thumbnail" style="max-width: 100px; margin: 5px;">
                        <label>
                            <input type="radio" name="imagenPrincipal" value="${index}" ${index === 0 ? 'checked' : ''} data-imgpro="${imagen.imgpro}" onclick="actualizarOrdenImagenes()">
                            Principal
                        </label>
                        <button type="button" onclick="eliminarImagen(${index}, true)" class="btn-del">
                            <i class="bi bi-x-circle-fill"></i>
                        </button>
                    `;
                    imageExistContainer.appendChild(imgDiv);
                });
                actualizarOrdenImagenes();
            }
        }

        // Mostrar el modal
        const modalElement = document.getElementById('exampleModal');
        if (modalElement) {
            const modal = new bootstrap.Modal(modalElement);
            modal.show();
        }

        // Configurar limpieza al cerrar el modal
        if (modalElement) {
            modalElement.addEventListener('hidden.bs.modal', limpiarModal);
        }
    } else {
        console.error('No se encontraron datos para el producto.');
        alert('No se encontraron datos para el producto. Verifica el ID.');
    }
}

// Esta función se ejecuta cada vez que se marca un radio button
function actualizarOrdenImagenes() {
    const imagenesPrincipales = document.querySelectorAll('input[name="imagenPrincipal"]'); // Radios de imágenes principales
    const formulario = document.getElementById('formUpdatePrd'); // Asegúrate de que este ID sea correcto

    if (!formulario) {
        console.error("El formulario con ID 'formUpdatePrd' no se encuentra en el DOM.");
        return;
    }

    // Eliminar inputs ocultos existentes para evitar duplicados
    const camposOrdenImagenes = formulario.querySelectorAll('input[name="ordenImagenes[]"]');
    camposOrdenImagenes.forEach(campo => campo.remove());

    // Crear nuevo orden de imágenes
    const ordenImagenes = [];
    imagenesPrincipales.forEach((radio, index) => {
        // Verifica si el radio tiene el atributo `data-imgpro`
        const imgpro = radio.dataset.imgpro || "";
        if (!imgpro) {
            console.warn(`El radio en la posición ${index} no tiene un atributo 'data-imgpro'.`);
            return;
        }

        // Determinar el orden
        const imagen = {
            imgpro, // Ruta de la imagen
            ordimg: radio.checked ? 1 : index + 2 // 1 si es principal, orden secuencial para las demás
        };
        ordenImagenes.push(imagen);

        // Crear input oculto para enviar al servidor
        const inputHidden = document.createElement('input');
        inputHidden.type = 'hidden';
        inputHidden.name = 'ordenImagenes[]'; // Nombre del campo enviado
        inputHidden.value = JSON.stringify(imagen); // Convertir a JSON
        formulario.appendChild(inputHidden);
    });
}

function obtenerImagenesExistentes() {
    // Selecciona todos los inputs con name="imagenesExistentes[]"
    const inputsExistentes = document.querySelectorAll('input[name="imagenesExistentes[]"]');
    // Extrae los valores de los inputs
    const valores = Array.from(inputsExistentes).map(input => input.value);

    return valores; // Devuelve un array con los valores
}

function limpiarModal() {
    // Limpiar campos del formulario
    document.getElementById('exampleModalLabel').innerHTML = 'Sin Artículo';
    document.querySelector('[name="nompro"]').value = '';
    document.querySelector('[name="descripcion"]').value = '';
    document.querySelector('[name="cantidad"]').value = '';
    document.querySelector('[name="idval"]').value = '';
    document.querySelector('[name="valorunitario"]').value = '';
    document.querySelector('[name="precio"]').value = '';
    document.querySelector('[name="pordescu"]').value = '';
    document.querySelector('[name="fechfinofer"]').value = '';
    document.querySelector('[name="idpro"]').value = '';

    // Limpiar contenedores dinámicos
    document.getElementById('descar').innerHTML = '';
    document.getElementById('orden-imagenes').innerHTML = '';
}


function cerrarModal() {
    // Obtener el modal y el backdrop
    const modalElement = document.getElementById('exampleModal');
    const modal = new bootstrap.Modal(modalElement);

    // Evento del botón de cierre
    const closeButton = document.querySelector('.btn-close');

    closeButton.addEventListener('click', function () {
        modal.hide();  // Cierra el modal
    });

    // Asegurarte de que el backdrop se elimine cuando el modal se cierra
    $(modalElement).on('hidden.bs.modal', function () {
        // Este código se ejecuta después de que el modal se cierra
        document.body.classList.remove('modal-open');  // Asegúrate de que el fondo no se quede visible
        const backdrop = document.querySelector('.modal-backdrop');
        if (backdrop) {
            backdrop.remove();  // Elimina el backdrop manualmente
        }
    });
}
(function ($) {
    $.fn.countTo = function (options) {
        options = options || {};

        return $(this).each(function () {
            // set options for current element
            var settings = $.extend({}, $.fn.countTo.defaults, {
                from: $(this).data('from'),
                to: $(this).data('to'),
                speed: $(this).data('speed'),
                refreshInterval: $(this).data('refresh-interval'),
                decimals: $(this).data('decimals')
            }, options);

            // how many times to update the value, and how much to increment the value on each update
            var loops = Math.ceil(settings.speed / settings.refreshInterval),
                increment = (settings.to - settings.from) / loops;

            // references & variables that will change with each update
            var self = this,
                $self = $(this),
                loopCount = 0,
                value = settings.from,
                data = $self.data('countTo') || {};

            $self.data('countTo', data);

            // if an existing interval can be found, clear it first
            if (data.interval) {
                clearInterval(data.interval);
            }
            data.interval = setInterval(updateTimer, settings.refreshInterval);

            // initialize the element with the starting value
            render(value);

            function updateTimer() {
                value += increment;
                loopCount++;

                render(value);

                if (typeof (settings.onUpdate) == 'function') {
                    settings.onUpdate.call(self, value);
                }

                if (loopCount >= loops) {
                    // remove the interval
                    $self.removeData('countTo');
                    clearInterval(data.interval);
                    value = settings.to;

                    if (typeof (settings.onComplete) == 'function') {
                        settings.onComplete.call(self, value);
                    }
                }
            }

            function render(value) {
                var formattedValue = settings.formatter.call(self, value, settings);
                $self.html(formattedValue);
            }
        });
    };

    $.fn.countTo.defaults = {
        from: 0,               // the number the element should start at
        to: 0,                 // the number the element should end at
        speed: 1000,           // how long it should take to count between the target numbers
        refreshInterval: 100,  // how often the element should be updated
        decimals: 0,           // the number of decimal places to show
        formatter: formatter,  // handler for formatting the value before rendering
        onUpdate: null,        // callback method for every time the element is updated
        onComplete: null       // callback method for when the element finishes updating
    };

    function formatter(value, settings) {
        return value.toFixed(settings.decimals);
    }
}(jQuery));

jQuery(function ($) {
    // custom formatting example
    $('.count-number').data('countToOptions', {
        formatter: function (value, options) {
            return value.toFixed(options.decimals).replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
        }
    });

    // start all the timers
    $('.timer').each(count);

    function count(options) {
        var $this = $(this);
        options = $.extend({}, options || {}, $this.data('countToOptions') || {});
        $this.countTo(options);
    }
});

document.addEventListener('DOMContentLoaded', function () {
    var modeSwitch = document.querySelector('.mode-switch');

    modeSwitch.addEventListener('click', function () {
        document.documentElement.classList.toggle('dark');
        modeSwitch.classList.toggle('active');
    });

    var listView = document.querySelector('.list-view');
    var gridView = document.querySelector('.grid-view');
    var projectsList = document.querySelector('.project-boxes');

    listView.addEventListener('click', function () {
        gridView.classList.remove('active');
        listView.classList.add('active');
        projectsList.classList.remove('jsGridView');
        projectsList.classList.add('jsListView');
    });

    gridView.addEventListener('click', function () {
        gridView.classList.add('active');
        listView.classList.remove('active');
        projectsList.classList.remove('jsListView');
        projectsList.classList.add('jsGridView');
    });

    document.querySelector('.messages-btn').addEventListener('click', function () {
        document.querySelector('.messages-section').classList.add('show');
    });

    document.querySelector('.messages-close').addEventListener('click', function () {
        document.querySelector('.messages-section').classList.remove('show');
    });
});


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
document.addEventListener('DOMContentLoaded', function () {
    cerrarModal();
    buttonsTablePedidos();
});
document.addEventListener('DOMContentLoaded', function () {
    buttonsTable();
});
window.addEventListener('load', () => {
    document.getElementById('valorunitario').addEventListener('input', calcularPrecio);
    document.getElementById('pordescu').addEventListener('input', calcularPrecio);
});


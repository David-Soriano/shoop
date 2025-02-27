<h4 class="txtven">
    Sube productos y empieza a facturar
</h4>
<div class="row bx-subprd">
    <div class="col" id="formven">
        <h5>Completa el formulario</h5>
        <form class="marco" name="frm1" action="../controller/cpancon.php" method="POST" enctype="multipart/form-data">
            <div class="row bx-inp-inf">
                <div class="col">
                    <input type="text" name="nompro" placeholder="Nombre del artículo" required>
                </div>
                <div class="col">
                    <textarea name="descripcion" placeholder="Añade una descripción" required></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <input type="number" name="cantidad" placeholder="Cantidad disponible" required>
                </div>
                <div class="col">
                    <select name="idval" required>
                        <option value="">Categoría</option>
                        <?php if (!empty($dtCatego)) {
                            foreach ($dtCatego as $dtcat) { ?>
                                <option value="<?= $dtcat['idval'] ?>"><?= $dtcat['categoria'] ?></option>
                            <?php }
                        } ?>
                    </select>
                </div>
            </div>
            <div class="row bx-subprd_valor">
                <div class="col">
                    <i class="bi bi-question-circle-fill"
                        title="Valor unitario: Es el precio por unidad antes de aplicar descuentos o recargos."></i>
                    <input type="number" id="valorunitario" name="valorunitario" placeholder="Valor Unitario" required>
                </div>
                <div class="col">
                    <i class="bi bi-question-circle-fill"
                        title="Precio: Es el costo final que paga el cliente, incluyendo descuentos o recargos."></i>
                    <input type="number" id="precio" name="precio" placeholder="Precio del producto" readonly>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h6>¿Algún descuento en especial?</h6>
                </div>
                <div class="col">
                    <input type="number" id="pordescu" name="pordescu" placeholder="Valor. Ej: 5%"
                        oninput="mostrarFechaFin()">
                </div>
            </div>
            <div class="row" id="fechaOferta" style="display: none;">
                <div class="col">
                    <label for="fechaFin">Fecha fin de la oferta:</label>
                    <input type="date" id="fechaFin" name="fechfinofer">
                </div>
            </div>
            <input type="hidden" id="fechaInicio" name="fechiniofer" value="">
            <div class="row">
                <div class="col">
                    <Label>Características del producto</Label>
                    <i class="bi bi-question-circle-fill" title="Cantidad de característica a registrar"></i>
                    <input type="number" name="" id="cantcr" placeholder="Cantidad" oninput="cantCr()">
                </div>
                <div class="col" id="descar">
                </div>
            </div>
            <div class="row bx-reg-file">
                <div class="col">
                    <label for="imgpro">Selecciona imágenes:</label>
                    <input type="file" name="imgpro[]" id="imgpro" multiple accept=".jpg, .jpeg, .png, .webp"
                        onchange="actualizarOrden()">
                </div>
            </div>
            <div class="row" id="orden-imagenes">
                <!-- Aquí se mostrarán las imágenes con su orden -->
            </div>
            <div class="row bx-subm">
                <input type="hidden" name="idusu" value="<?= $_SESSION['idusu'] ?>">
                <input type="hidden" name="ope" value="save">
                <div class="col">
                    <input type="submit" value="Cargar" onclick="añadirImagenes()">
                </div>
                <div class="col">
                    <p>¿Tienes muchos artículos para subir? Ingresa <a href="#" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">Aquí</a></p>
                </div>
            </div>
        </form>
    </div>


    <!-- Apartado para mostrar el desglose -->
    <div class="col">
        <h5>Conoce los resultados</h5>
        <div class="col marco" id="desglose">
            <p id="detalle">
                Aquí veras el cálculo para el precio final.
            </p>
        </div>
    </div>

</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Carga Masiva de Productos</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formCargaMasiva" action="../controller/cargar_productos.php" method="POST"
                    enctype="multipart/form-data">
                    <p>Antes de continuar siga las <a href="" title="Instrucciones">Indicaciones</a></p>
                    <div class="row">
                        <div class="col">
                            <input type="checkbox" name="confirmInd" id="confirmInd">
                            <label for="confirmInd" class="lbconfirmInd">Leí las indicaciones</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="archivo-excel" class="col-form-label">Selecciona el archivo Excel:</label>
                        <input type="file" class="form-control" id="archivo-excel" name="archivo_excel"
                            accept=".xlsx,.xls" required>
                    </div>

                    <div id="imagenesContainer" class="mb-3">
                        <!-- Aquí se insertarán dinámicamente los inputs de imágenes -->
                    </div>

                    <div class="modal-footer">
                        <a href="../plantillas/Plantilla_Carga_Productos.xlsx" download>Descargar
                            Plantilla</a>
                        <div>
                            <button type="submit" class="btn btn-primary">Cargar Productos</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
</div>

<script>
    const contFiles = document.getElementById('imagenesContainer');
    const confirmCheckbox = document.getElementById("confirmInd");
    const fileInput = document.getElementById("archivo-excel");

    // Deshabilitar input al cargar la página
    fileInput.disabled = true;

    // Habilitar/deshabilitar según el checkbox
    confirmCheckbox.addEventListener("change", function () {
        fileInput.disabled = !this.checked;
    });
    
    contFiles.style.display = 'none';

    fileInput.addEventListener('change', function (event) {
        contFiles.style.display = 'block';
        const file = event.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function (e) {
            const data = new Uint8Array(e.target.result);
            const workbook = XLSX.read(data, { type: 'array' });
            const sheetName = workbook.SheetNames[0];
            const sheet = workbook.Sheets[sheetName];
            const jsonData = XLSX.utils.sheet_to_json(sheet, { header: 1 });

            // Limpiar contenedor antes de agregar nuevos inputs
            const imagenesContainer = document.getElementById('imagenesContainer');
            imagenesContainer.innerHTML = '';

            // Iterar desde la segunda fila (para ignorar el encabezado)
            jsonData.slice(1).forEach((row, index) => {
                const productName = row[0]; // Columna A - Nombre del producto
                const imageName = row[6]; // Columna G - Nombre de la imagen

                if (!productName || !imageName) return; // Ignorar filas sin datos

                // Crear el label y el input
                const label = document.createElement('label');
                label.innerHTML = `Imagen para <u><i>${productName}</i></u> (<u><b>${imageName}</b></u>):`;
                label.classList.add('col-form-label');

                const input = document.createElement('input');
                input.type = 'file';
                input.classList.add('form-control');
                input.name = `imagenes_productos[${index}][]`;
                input.accept = ".jpg, .jpeg, .png, .webp";
                input.multiple = true;

                // Agregar al contenedor
                imagenesContainer.appendChild(label);
                imagenesContainer.appendChild(input);
            });
        };

        reader.readAsArrayBuffer(file);
    });
</script>
<h4 class="txtven">
    Sube productos y empieza a facturar
</h4>
<div class="row bx-subprd">
    <div class="col" id="formven">
        <h5>Completa el formulario</h5>
        <form class="marco" name="frm1" action="../controller/cpancon.php" method="POST" enctype="multipart/form-data">
            <div class="row">
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
            <div class="row">
                <div class="col">
                    <label for="imgpro">Selecciona imágenes:</label>
                    <input type="file" name="imgpro[]" id="imgpro" multiple accept=".jpg, .jpeg, .png, .webp"
                        onchange="actualizarOrden()" required>
                </div>
            </div>
            <div class="row" id="orden-imagenes">
                <!-- Aquí se mostrarán las imágenes con su orden -->
            </div>
            <div class="row bx-subm">
                <input type="hidden" name="idusu" value="<?= $_SESSION['idusu'] ?>">
                <input type="hidden" name="ope" value="save">
                <div class="col">
                    <input type="submit" value="Cargar">
                </div>
                <div class="col">
                    <p>¿Tienes muchos artículos para subir? Ingresa <a href="#">Aquí</a></p>
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
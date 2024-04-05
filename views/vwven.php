    <h1 class="txtven">
        <div class="es1"><i class="fa-solid fa-truck-field"></i></div>
        Mis productos de venta
    </h1>
    <i class="fa-solid fa-circle-plus fa-2x btnadd" id="btnadd"></i>
    <div id="formven">
        <form name="frm1" action="#" method="POST">
            <div class="row">
                <div class="form-group col-md-4">
                    <label>Producto</label>
                    <input type="text" class="form-control form-control" required>
                </div>
                <div class="form-group col-md-8">
                    <label>Descripción</label>
                    <textarea class="form-control form-control"></textarea>
                </div>
                <div class="form-group col-md-4">
                    <label>Existencias</label>
                    <input type="number" class="form-control form-control" required>
                </div>
                <div class="form-group col-md-4">
                    <label>Precio</label>
                    <input type="number" class="form-control form-control" required>
                </div>
                <div class="mb-3">
                    <label for="formFileMultiple" class="form-label">Sube las imagenes del producto</label>
                    <input class="form-control" type="file" id="formFileMultiple" multiple>
                </div>
                <div class="form-group col-md-4">
                    <br>
                    <input type="button" class="btn btn-primary" id="venpro" value="Enviar">
                </div>
            </div>
        </form>
    </div>
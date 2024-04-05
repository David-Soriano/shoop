<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<div class="container mt-5">
        <h1>Subir Producto</h1>
        <form>
            <div class="form-group">
                <label for="product-name">Nombre del Producto</label>
                <input type="text" class="form-control" id="product-name" placeholder="Ingresar Nombre del Producto">
            </div>
            <div class="form-group">
                <label for="product-description">Descripción del Producto</label>
                <textarea class="form-control" id="product-description" rows="3" placeholder="Ingresar Descripción del Producto"></textarea>
            </div>
            <div class="form-group">
                <label for="product-image">Imagen del Producto</label>
                <input type="file" class="form-control-file" id="product-image">
            </div>
            <div class="form-group">
                <label for="product-price">Precio del Producto</label>
                <input type="number" class="form-control" id="product-price" placeholder="Ingresar Precio del Producto">
            </div>
            <div class="form-group">
                <label for="product-category">Categoria del Producto</label>
                <input type="text" class="form-control" id="product-category" placeholder="Ingresar Categoria del Producto">
            </div>
            <button type="submit" class="btn btn-primary">Subir</button>
        </form>
    </div>
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script> -->
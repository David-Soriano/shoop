<div class="container my-5">
    <div class="card p-4">
        <h2 class="text-center fw-bold">Tus Compras</h2>

        <div class="card my-3">
            <div class="card-body border mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <!-- Información del producto -->
                    <div>
                        <h4 class="fw-bold">Nombre Producto</h4>

                        <!-- Estados del pedido -->
                        <div class="d-flex align-items-center mt-2">
                            <div class="me-3 text-center">
                                <span class="dot"></span>
                                <p class="small">Confirmado</p>
                            </div>
                            <div class="me-3 text-center">
                                <span class="dot"></span>
                                <p class="small">Enviado</p>
                            </div>
                            <div class="me-3 text-center">
                                <span class="dot"></span>
                                <p class="small">En Tránsito</p>
                            </div>
                            <div class="me-3 text-center">
                                <span class="dot"></span>
                                <p class="small">En Reparto</p>
                            </div>
                            <div class="me-3 text-center">
                                <span class="dot"></span>
                                <p class="small">Recibido</p>
                            </div>
                        </div>
                    </div>

                    <!-- Imagen del producto -->
                    <div>
                        <img src="ruta_por_defecto.jpg" alt="Imagen del Producto" class="img-thumbnail" style="width: 100px; height: 100px;">
                    </div>
                </div>

                <!-- Acciones -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <a href="#" class="btn btn-outline-danger">Detalles</a>
                    <a href="#" class="btn btn-link">Cancelar pedido</a>
                    <a href="#" class="btn btn-outline-success">Recibido</a>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    .dot {
        display: inline-block;
        width: 15px;
        height: 15px;
        border-radius: 50%;
        background-color: #ccc;
    }

    .dot-active {
        background-color: #ff0000;
    }
</style>

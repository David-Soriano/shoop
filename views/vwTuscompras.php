
<div class="container my-5">
    <div class="card p-3">
        <h2 class="text-center fw-bold">Tus Compras</h2>

        <div class="card my-3">
            <?php foreach($dtcompra as $dtcp){?>
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    
                    <p>Información Breve: 
                        <p><?=$dtcp['PrecioCompra']?></p>
                </div>
                <div>
         
                    <a href="#" class="btn btn-outline-danger">Detalles</a>
                </div>
            </div>
            <?php }?>
        </div>

    </div>
</div>
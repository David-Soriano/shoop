<div class="container bx-cont-carr-pro">
    <div class="row bx-prp-carr-comp" <?php if(!$isLoggedIn) echo "style='display: flex; justify-content: center;'";?>>
        <div class="col-6 bx-items-carr-comp" >
            <div class="col-4">
                <img src="IMG/carroVacio.svg" alt="">
            </div>
            <div class="col-6">
                <?php echo $isLoggedIn ? "<h4>Mi estimado(a), el carro esta vacío</h4>" : "<h4>Inicia sesión para ver tu carrito</h4>";?>
                
                <p>Agrega productos y los veras aquí</p>
            </div>
            <?php echo $isLoggedIn ? "<button><a href='views/vwLogin.php'>Encontrar Articulos</a></button>" : "<button><a href='views/vwLogin.php'>Iniciar Sesión</a></button>";?>
        </div>
        <?php if ($isLoggedIn) { ?>
            <div class="col-5 bx-res-carr-comp">
                <div class="col">
                    <h5>Resumen de la compra</h5>
                </div>
                <div class="col">
                    <p>Agrega productos para calcular tu importe.</p>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<div class="container bx-cont-carr-pro">
    <div class="row bx-prp-carr-comp" <?php if (!$isLoggedIn)
        echo "style='display: flex; justify-content: center;'"; ?>>
        <div class="col-6 bx-items-carr-comp">
            <?php if ($isLoggedIn) { ?>
                <!--Dariana-->
                <!-- Producto 1 -->
                <div class="product">
                    <div class="product-image">
                        <img src="proinf/camiseta.png" alt="Camiseta de algodón">
                    </div>
                    <div class="product-details">
                        <h5>Camiseta de algodón</h5>
                        <p>LOVITO OFFICIAL STORE</p>
                        <p>Variaciones: Talla única</p>
                        <p>Variaciones: Talla única</p>
                    </div>
                    <div class="product-actions">
                        <div class="row product-actions_opt">
                            <div class="col">
                                <input type="number" class="quantity" value="2">
                                <span class="total">COP 52,054</span>
                            </div>
                        </div>
                        <div class="row product-actions_opt">
                            <div class="col">
                                <a href="#" title="Eliminar"><i class="bi bi-x"></i></a>
                                <a href="#" title="Buscar Similar"><i class="bi bi-search-heart"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Resumen del carrito -->
                <div class="footer">
                    <div>
                        <label for="select-all">Seleccionar Todo</label>
                        <input type="checkbox" id="select-all">
                        <span>|</span>
                        <a href="#">Eliminar productos inactivos</a>
                    </div>
                    <div>
                        Total: COP 52,054
                    </div>
                    <button class="continue-button">Continuar</button>
                </div>
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
    <?php } else { ?>
        <div class="col-4">
            <img src="IMG/carroVacio.svg" alt="">
        </div>
        <div class="col-6">
            <?php echo $isLoggedIn ? "<h4>Mi estimado(a), el carro esta vacío</h4>" : "<h4>Inicia sesión para ver tu carrito</h4>"; ?>

            <p>Agrega productos y los veras aquí</p>
        </div>
        <?php echo $isLoggedIn ? "<button><a href='views/vwLogin.php'>Encontrar Articulos</a></button>" : "<button><a href='views/vwLogin.php'>Iniciar Sesión</a></button>"; ?>
    <?php } ?>
</div>
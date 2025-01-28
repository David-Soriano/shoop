<div class="container bx-cont-carr-pro">
    <div class="row bx-prp-carr-comp" <?php if (!$isLoggedIn)
        echo "style='display: flex; justify-content: center;'"; ?>>
        <div class="col-6 bx-items-carr-comp">
            <?php if ($isLoggedIn) { ?>
                <?php if (!empty($_SESSION['carrito'])) { ?>
                    <?php foreach ($_SESSION['carrito'] as $producto) { ?>
                        <div class="product">
                            <div class="product-image">
                                <img src="<?php echo htmlspecialchars($producto['imagen'] ?? 'default-image.png'); ?>"
                                    alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                            </div>
                            <div class="product-details">
                                <h6><?php echo htmlspecialchars($producto['nombre']); ?></h6>
                                <p>Precio unitario: COP <?php echo number_format($producto['precio'], 2); ?></p>
                                <p>Cantidad: <?php echo htmlspecialchars($producto['cantidad']); ?></p>
                                <p>Subtotal: COP $<?= number_format($producto['cantidad'] * $producto['precio'], 0, ",", "."); ?>
                                </p>
                            </div>
                            <div class="product-actions">
                                <div class="row product-actions_opt">
                                    <div class="col">
                                        <input type="number" class="quantity"
                                            value="<?php echo htmlspecialchars($producto['cantidad']); ?>">
                                        <span class="total">$
                                            <?= number_format($producto['cantidad'] * $producto['precio'], 0, ",", "."); ?></span>
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

                    <?php } ?>
                    <div class="footer">
                        <div>
                            <label for="select-all">Seleccionar Todo</label>
                            <input type="checkbox" id="select-all">
                            <span>|</span>
                            <a href="#">Eliminar productos inactivos</a>
                        </div>
                        <button class="continue-button"><a href="home.php?pg=29">Continuar</a></button>
                    </div>
                <?php } else { ?>
                    <div class="col-4">
                        <img src="IMG/carroVacio.svg" alt="">
                    </div>
                    <div class="col-6">
                        <h4>Mi estimado(a), el carro esta vacío</h4>
                    </div>
                    <button><a href='home.php'>Encontrar Articulos</a></button>
                <?php } ?>

                <!-- Resumen del carrito -->
            </div>
            <?php if ($isLoggedIn) {
                if (!empty($_SESSION['carrito'])) { ?>
                    <div class="col-5 bx-res-carr-comp">
                        <div class="col">
                            <h5>Resumen de la compra</h5>
                        </div>
                        <div class="col">
                            <table>
                                <tbody>
                                    <?php
                                    $total = 0; // Inicializa la variable acumuladora
                                    foreach ($_SESSION['carrito'] as $producto):
                                        $subtotal = $producto['cantidad'] * $producto['precio']; // Calcula el subtotal del producto
                                        $total += $subtotal; // Suma el subtotal al total
                                        ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                                            <td><?= number_format($subtotal, 0, ",", "."); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <tr>
                                        <th>TOTAL</th>
                                        <td><?= number_format($total, 0, ",", "."); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="col-5 bx-res-carr-comp">
                        <div class="col">
                            <h5>Resumen de la compra</h5>
                        </div>
                        <div class="col">
                            <p>Agrega productos para calcular tu importe.</p>
                        </div>
                    </div>
                <?php }
            } ?>
        </div>
    <?php } else { ?>
        <div class="col-4">
            <img src="IMG/carroVacio.svg" alt="">
        </div>
        <div class="col-6">
            <h4>Inicia sesión para ver tu carrito</h4>

            <p>Agrega productos y los veras aquí</p>
        </div>
        <button><a href='views/vwLogin.php'>Iniciar Sesión</a></button>
    <?php } ?>
</div>
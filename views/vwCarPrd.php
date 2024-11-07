<div class="row bx-mr-car-prd">
    <h5>Y las Características...</h5>
    <div class="row bx-car-items">
        <?php if (!empty($dtCarprd)) { ?>
            <?php 
            $hasFeatures = false; // Inicializamos una variable para comprobar si hay alguna característica válida
            foreach ($dtCarprd as $dtcar) { 
                if (!empty($dtcar['descripcion'])) {
                    $hasFeatures = true; // Indicamos que se encontró al menos una característica
                    ?>
                    <div class="item-car col-4">
                        <i class="bi bi-patch-check"></i>
                        <p><?= $dtcar['descripcion']; ?></p>
                    </div>
                <?php } 
            }
            // Si no se encontraron características válidas, mostramos el mensaje
            if (!$hasFeatures) { ?>
                <div class="item-car col-4">
                    <p>No hay características disponibles</p>
                </div>
            <?php } ?>
        <?php } else { ?>
            <div class="item-car col-4" style="margin: auto; width: 20vh;">
                <p>No hay características disponibles</p>
            </div>
        <?php } ?>
    </div>
</div>

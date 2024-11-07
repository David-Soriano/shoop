<div class="row bx-des-prd" id="bx-des-prd">
    <h5>Descripción</h5>
    <div class="col-10">
        <?php 
        if (!empty($dtInfPrd) && !empty($dtInfPrd[0]['descripcion'])) { ?>
            <p><?= $dtInfPrd[0]['descripcion'] ?></p>
        <?php } else { ?>
            <p style="text-align: center;">El vendedor no añadió una descripción</p>
        <?php } ?>
    </div>
</div>


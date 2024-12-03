<div class="container my-5">
    <div class="card p-3">
        <h2 class="text-center fw-bold">Tus Pedidos</h2>

        <div class="card my-3">
            <?php foreach($dtpedido as $dtpd){?>
            <div class="card-body d-flex justify-content-between align-items-center bx_tusped">
                <div>
                    <h5 class="fw-bold"><?=$dtpd['total']?></h5>
                      
                    <p><?=$dtpd['fecha']?></p>
                    <p><?=$dtpd['estped']?></p>
                    <img src="<?=$dtpd['imgpro']?>" alt="<?=$dtpd['nompro']?>">
                    <p></p>

                </div>
                <a href="home.php?pg=28" class="btn btn-outline-danger">Seguir Envío</a>
            </div>
            <?php }?>
        </div>

    </div>
</div>
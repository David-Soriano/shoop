<div class="container">
    <div class="row bx-conf-pef-prin">
        <div class="row">
            <div class="row bx-conf-pef">
                <div class="col-4 bx-conf-pef-cont">
                    <div class="row bx-conf-pef-ini">
                        <div class="col-2 circle">
                            <p><?= $iniciales = strtoupper(substr($_SESSION['nomusu'], 0, 1) . substr($_SESSION['apeusu'], 0, 1)); ?>
                            </p>
                        </div>
                        <div class="col-7 nombre">
                            <h5><?= $_SESSION['nomusu'] ?> <?= $_SESSION['apeusu'] ?></h5>
                            <p><?= $_SESSION['emausu'] ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row bx-conf-pef">
                <a href="" class="col-3 bx-conf-pef-item">
                    <h5>Información Personal</h5>
                </a>
                <a href="" class="col-3 bx-conf-pef-item">
                    <h5>Datos de tu Cuenta</h5>
                </a>
                <a href="" class="col-3 bx-conf-pef-item">
                    <h5>Seguridad</h5>
                </a>
                <a href="" class="col-3 bx-conf-pef-item">
                    <h5>Formas de Pago</h5>
                </a>
                <a href="" class="col-3 bx-conf-pef-item">
                    <h5>Direcciones</h5>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p>Si lo deseas puedes <a href="">Cancelar tu cuenta</a></p>
            </div>
        </div>
    </div>
</div>
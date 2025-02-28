<div class="container">
    <div class="row bx-conf-pef-prin">
        <div class="row">
            <div class="row bx-conf-pef-bx">
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
                <?php $msj = isset($_REQUEST['msj']) ? $_REQUEST['msj'] : NULL; 
                switch($msj){
                    case 1:
                        echo '<div class="alert alert-success" style="margin: 1% 0;" role="alert">Los cambios se han realizado con éxito.</div>';
                        break;
                    case 2:
                        echo '<div class="alert alert-danger" style="margin: 1% 0;" role="alert">No se pudieron realizar los cambios.</div>';
                        break;
                    case 3:
                        echo '<div class="alert alert-danger" style="margin: 1% 0;" role="alert">La contraseña actual no coincide.</div>';
                        break;
                }?>
            </div>
            <div class="row bx-conf-pef">
                <a href="#" class="col-3 bx-conf-pef-item" onclick="cargarContenido('views/vwInfo-Personal.php')">
                    <h5>Información Personal</h5>
                </a>
                <a href="#" class="col-3 bx-conf-pef-item" onclick="cargarContenido('views/vwDatos-Cuenta.php')">
                    <h5>Datos de tu Cuenta</h5>
                </a>
                <!-- <a href="#" class="col-3 bx-conf-pef-item" onclick="cargarContenido('views/vwSeguridad.php')">
                    <h5>Seguridad</h5>
                </a> -->
                <!-- <a href="#" class="col-3 bx-conf-pef-item">
                    <h5>Formas de Pago</h5>
                </a> -->
                <a href="#" class="col-3 bx-conf-pef-item" onclick="cargarContenido('views/vwDirecciones.php')">
                    <h5>Direcciones</h5>
                </a>
            </div>
            <div id="contenido"></div>
        </div>
        <div class="row">
            <div class="col">
                <p>Si lo deseas puedes <a href="">Cancelar tu cuenta</a></p>
            </div>
        </div>
    </div>
</div>
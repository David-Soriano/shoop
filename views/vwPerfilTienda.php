<div class="container">
    <div class="row bx-conf-pef-prin">
        <div class="row">
            <div class="row bx-conf-pef-bx">
                <div class="col-sm-4 col bx-conf-pef-cont">
                    <div class="row bx-conf-pef-ini">
                        <div class="col-2 circle">
                            <p><?= $iniciales = strtoupper(substr($dtProv['nomprov'], 0, 1)); ?>
                            </p>
                        </div>
                        <div class="col-7 nombre">
                            <h5><?= $dtProv['nomprov'] ?></h5>
                            <p><?= $dtProv['desprv'] ?></p>
                        </div>
                    </div>
                </div>
                <?php $msj = isset($_REQUEST['ms']) ? $_REQUEST['ms'] : NULL;
                switch ($msj) {
                    case 1:
                        echo '<div class="alert alert-success" style="margin: 1% 0;" role="alert">Los cambios se han realizado con éxito.</div>';
                        break;
                    case 2:
                        echo '<div class="alert alert-danger" style="margin: 1% 0;" role="alert">No se pudieron realizar los cambios.</div>';
                        break;
                    case 3:
                        echo '<div class="alert alert-danger" style="margin: 1% 0;" role="alert">La contraseña actual no coincide.</div>';
                        break;
                } ?>
            </div>
            <div class="row bx-conf-pef">
                <a href="#" class="col-sm-3 col bx-conf-pef-item" onclick="cargarContenido('../views/vwInfo-general.php')">
                    <h5>Información General</h5>
                </a>
                <a href="#" class="col-sm-3 col bx-conf-pef-item" onclick="cargarContenido('../views/vwDatos-tienda.php')">
                    <h5>Datos de tu Tienda</h5>
                </a>
                <!-- <a href="#" class="col-3 bx-conf-pef-item" onclick="cargarContenido('views/vwSeguridad.php')">
                    <h5>Seguridad</h5>
                </a> -->
                <!-- <a href="#" class="col-3 bx-conf-pef-item">
                    <h5>Formas de Pago</h5>
                </a> -->
                <a href="#" class="col-sm-3 col bx-conf-pef-item" onclick="cargarContenido('../views/vwDirecciones-Prv.php')">
                    <h5>Direcciones</h5>
                </a>
            </div>
            <div id="contenido"></div>
        </div>
        <div class="row">
            <div class="col">
                <p>Si lo deseas puedes <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">Cancelar tu
                        cuenta</a></p>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">¿Quieres cancelar tu cuenta?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Antes de continuar, elige qué deseas hacer:</p>

                <div class="mb-3">
                    <h5>🔹 Inactivar mi cuenta</h5>
                    <p>Tu cuenta quedará deshabilitada, pero tus datos seguirán almacenados. Podrás reactivarla cuando
                        lo desees iniciando sesión nuevamente.</p>
                    <form action="../controller/cprov.php" method="post">
                        <input type="hidden" name="oper" value="inactivar">
                        <input type="hidden" name="idprov" value="<?= $dtProv['idprov'] ?>">
                        <button type="submit" class="btn btn-warning" id="btnInactivar">Inactivar cuenta</button>
                    </form>
                </div>

                <!-- <div class="mb-3">
                    <h5>❌ Eliminar mi cuenta</h5>
                    <p>Si eliges esta opción, tu cuenta y todos tus datos serán eliminados permanentemente. Esta acción
                        no se puede deshacer.</p>
                    <button type="button" class="btn btn-danger" id="btnEliminar">Eliminar cuenta</button>
                </div> -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<script src="../JS/script.js"></script>
<script>
    setTimeout(function () {
        var message = document.querySelector('.alert');
        if (message) {
            message.remove();
            let url = new URL(window.location);
            url.searchParams.delete("ms"); // Elimina el parámetro "ms"
            url.hash = ""; // Elimina cualquier hash (#)

            window.history.replaceState(null, "", url.pathname + url.search);
        }
    }, 5000);
</script>
<?php session_start();
include_once "../controller/cubi.php";
include_once "../controller/cusu.php";
require_once("../controller/cpancon.php");
$dtProvData = getDtProv($_SESSION['idprov']);
$dtProv = $dtProvData[0];
$ubicacionprv = obtenerUbicacion($dtProv['idubi']);
$departamentoIDprv = $ubicacionprv['departamentoID'];
$dtDtpprv = $ubicacionprv['dtDtp'];
$ciudadesprv = $ubicacionprv['ciudades'];
?>
<div class="bx-content-pf">
    <h3>Direcciones</h3>
    <form id="formDirecciones" class="form-conf-pef" method="post" action="../controller/cprov.php">
        <label for="dirrecprov">Dirección:</label>
        <input type="text" id="dirrecprov" name="dirrecprov" value="<?= $dtProv['dirrecprov']?>" required>

        <div class="row" style="margin: 1% 0 4%;">
            <div class="col">
                <label for="depart">Departamento:</label>
                <select name="depart" id="depart" class="form-control">
                    <option value="">Seleccione</option>
                    <?php foreach ($dtDtpprv as $dtD) { ?>
                        <option value="<?= $dtD['idubi']; ?>" <?= ($dtD['idubi'] == $departamentoIDprv) ? 'selected' : ''; ?>>
                            <?= $dtD['nomubi']; ?>
                        </option>
                    <?php } ?>
                </select>

                <label for="ciudad">Ciudad:</label>
                <select class="form-control" name="ciudad" id="ciudad">
                    <option value="">Seleccione</option>
                    <?php foreach ($ciudadesprv as $ciu) { ?>
                        <option value="<?= $ciu['idubi']; ?>" <?= ($ciu['idubi'] == $dtProv['idubi']) ? 'selected' : ''; ?>>
                            <?= $ciu['nomubi']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <input type="hidden" name="oper" value="editPrv3">
        <input type="hidden" name="idprov" value="<?php echo $_SESSION['idprov'];?>">
        <button type="submit" class="btn btn-primary">Guardar Dirección</button>
    </form>

    <div id="mensajeDirecciones"></div>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
</div>

<script>
    $(document).ready(function () {
    $("#depart").change(function () {
        var departamentoID = $(this).val();

        if (departamentoID !== "") {
            $.ajax({
                url: "../controller/cubi.php",
                type: "POST",
                data: { idubi: departamentoID },
                dataType: "json",
                success: function (data) {
                    var opciones = '<option value="">Seleccione</option>';
                    
                    if (data.length > 0) {
                        $.each(data, function (index, ciudad) {
                            opciones += '<option value="' + ciudad.idubi + '">' + ciudad.nomubi + '</option>';
                        });
                    } else {
                        opciones = '<option value="">No hay ciudades disponibles</option>';
                    }

                    $("#ciudad").html(opciones);
                },
                error: function (xhr, status, error) {
                    console.error("Error en AJAX:", error);
                    $("#ciudad").html('<option value="">Error al cargar ciudades</option>');
                }
            });
        } else {
            $("#ciudad").html('<option value="">Seleccione un departamento primero</option>');
        }
    });
});


</script>
<?php session_start();
include_once "../controller/cubi.php";
include_once "../controller/cusu.php";
?>
<div class="bx-content-pf">
    <h3>Direcciones</h3>
    <form id="formDirecciones" class="form-conf-pef" method="post" action="controller/cusu.php">
        <label for="dirrecusu">Dirección:</label>
        <input type="text" id="dirrecusu" name="dirrecusu" value="<?= $_SESSION['dirrecusu'] ?>" required>

        <div class="row" style="margin: 4% 0;">
            <div class="col">
                <label for="depart">Departamento:</label>
                <select name="depart" id="depart" class="form-control">
                    <option value="">Seleccione</option>
                    <?php foreach ($dtDtp as $dtD) { ?>
                        <option value="<?= $dtD['idubi']; ?>" <?= ($dtD['idubi'] == $departamentoID) ? 'selected' : ''; ?>>
                            <?= $dtD['nomubi']; ?>
                        </option>
                    <?php } ?>
                </select>

                <label for="ciudad">Ciudad:</label>
                <select class="form-control" name="ciudad" id="ciudad">
                    <option value="">Seleccione</option>
                    <?php foreach ($ciudades as $ciu) { ?>
                        <option value="<?= $ciu['idubi']; ?>" <?= ($ciu['idubi'] == $idubiUsuario) ? 'selected' : ''; ?>>
                            <?= $ciu['nomubi']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>

                        <input type="hidden" name="ope" value="editDir">
        <button type="submit" class="btn btn-primary">Guardar Dirección</button>
    </form>

    <div id="mensajeDirecciones"></div>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
</div>

<script>
   $(document).ready(function () {
    $("#depart").change(function () {
        var departamentoID = $(this).val();
        if (departamentoID != "") {
            $.ajax({
                url: "controller/cubi.php",
                type: "POST",
                data: { idubi: departamentoID },
                dataType: "json",
                success: function (data) {
                    var opciones = '<option value="">Seleccione</option>';
                    $.each(data, function (index, ciudad) {
                        opciones += '<option value="' + ciudad.idubi + '">' + ciudad.nomubi + '</option>';
                    });
                    $("#ciudad").html(opciones);
                }
            });
        } else {
            $("#ciudad").html('<option value="">Seleccione un departamento primero</option>');
        }
    });
});

</script>
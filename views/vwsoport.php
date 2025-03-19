<div class="container">
    <div class="row bx-suport">
        <div class="col-4 bx-suport_text">
            <img src="IMG/nicepages/544444.jpg" alt="">
            <h5>Estamos para ayudarte</h5>
            <p><i class="bi bi-at"></i> toshoop2024@gmail.com</p>
        </div>
        <div class="col bx-form-suport">
            <form action="controller/cpqr.php" method="post">
                <div class="row">
                    <div class="col">
                        <label for="nomusu">Nombre Completo</label>
                        <input type="text" name="nomusu" id="nomusu" placeholder="Ej. David Gomez" required>
                    </div>
                </div>
                <div class="row bx-form-suport_corr-qj">
                    <div class="col">
                        <label for="emausu">Correo Electrònico</label>
                        <input type="email" name="emausu" id="emausu" placeholder="correo@example.com" required>
                    </div>
                    <div class="col">
                        <label for="tippqr">Tipo</label>
                        <select class="form-control" name="tippqr" id="tippqr">
                            <option value="Queja">Queja</option>
                            <option value="Sugerencia">Sugerencia</option>
                            <option value="Reclamo">Reclamo</option>
                            <option value="Felicitación">Felicitaciones</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="mensaje">Asunto</label>
                        <textarea name="mensaje" id="mensaje" placeholder="En que podemos ayudarle" required></textarea>
                    </div>
                </div>
                <div class="row">
                    <?php if (isset($_SESSION['idusu'])) { ?>
                        <input type="hidden" name="idusu" value="<?=$_SESSION['idusu']?>">
                    <?php } ?>
                    <button type="submit">Enviar</button>
                </div>
            </form>
        </div>
    </div>
</div>
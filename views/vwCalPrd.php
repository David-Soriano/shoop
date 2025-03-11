<?php $calificacion = ["Muy Mal", "Algo Mal", "Regular", "Perfecto", "Increíble"]; ?>
<div class="container my-5 bx-tusped-gen bx-calificar">
    <div class="row bx-seg-env bx-tusped-gen-n2">
        <div class="col">
            <h4><?= $dtInfPrd[0]['nompro'] ?></h4>
            <div class="row bx-stars mt-5" id="rating-stars">
                <?php foreach ($calificacion as $index => $cf) { ?>
                    <div class="col text-center star" data-value="<?= $index + 1 ?>">
                        <i class="bi bi-star"></i>
                        <p><?= $cf ?></p>
                    </div>
                <?php } ?>
            </div>

            <form action="controller/crev.php" method="post" class="form-cal">
                <input type="hidden" name="rating" id="rating-value" value="0">
                <!-- Guarda el valor de la calificación -->
                <input type="hidden" name="idusu" value="<?= $_SESSION['idusu'] ?>">
                <input type="hidden" name="idpro" value="<?= $dtInfPrd[0]['idpro'] ?>">
                <div class="row bx-opinion">
                    <div class="col">
                        <textarea name="comentario" id="comentario" placeholder="Opinión Personal"></textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <button type="submit" class="btn btn-outline-danger">Calificar</button>
                    </div>
                    <div class="col">
                        <button type="button" class="btn btn-outline-primary">Subir Imagen</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="col">
            <div class="row my-5">
                <div class="col bx-seg-env_img">
                    <img src="<?= $dtInfPrd[0]['imgpro'] ?>" alt="Imagen" class="img-thumbnail img-sg-env">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script para manejar la calificación -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const stars = document.querySelectorAll(".star");
        const ratingInput = document.getElementById("rating-value");

        stars.forEach(star => {
            star.addEventListener("click", function () {
                let value = this.getAttribute("data-value");
                ratingInput.value = value; // Guardar el valor seleccionado

                // Actualizar las estrellas visualmente
                stars.forEach((s, index) => {
                    if (index < value) {
                        s.querySelector("i").classList.remove("bi-star");
                        s.querySelector("i").classList.add("bi-star-fill");
                    } else {
                        s.querySelector("i").classList.remove("bi-star-fill");
                        s.querySelector("i").classList.add("bi-star");
                    }
                });
            });
        });
    });
</script>
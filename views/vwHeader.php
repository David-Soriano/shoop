<header class="d-flex header">
    <a href="<?= $isLoggedIn ? "home.php" : "index.php"; ?>"><img src="IMG/LogoAnimado.gif" alt=""></a>
    <div class="cont">
        <!-- Formulario para la búsqueda -->
        <input type="search" name="query" id="search-input" placeholder="Buscar productos" required>

        <!-- Botón de búsqueda (Opcional, ya que el script funcionará solo con el input) -->
        <div class="btns">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-search"
                viewBox="0 0 16 16">
                <path
                    d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
            </svg>
        </div>
    </div>

    <!-- Contenedor donde se mostrarán los resultados de la búsqueda -->
    <div id="search-results"></div>

    <div class="icons col-2">
        <div class="col-4 ico-items">
            <?php foreach ($dtMenHead as $dmh): ?>
                <a href="<?= $isLoggedIn ? $dmh['url2'] : $dmh['url']; ?>" title="<?= $dmh['nombre']; ?>">
                    <i class="<?= $dmh['icomen']; ?>"></i>
                </a>
            <?php endforeach ?>
        </div>
        <div class="inf-perfil">
            <a href="#" id="btnPrf">
                <?php if (!$isLoggedIn) { ?>
                    <i class="bi bi-person-circle"></i>
                <?php } else {
                    // Obtener la inicial del nombre
                    $nomusu = isset($_SESSION['nomusu']) ? $_SESSION['nomusu'] : "";
                    $inicial = strtoupper(substr($nomusu, 0, 1));
                    ?>
                    <div class="perfil-circulo"><?php echo $inicial; ?></div>
                <?php } ?>
            </a>
            <?php include "views/vwOpcMen.php"; ?>
        </div>
    </div>
</header>
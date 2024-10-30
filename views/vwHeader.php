<header class="d-flex header">
    <a href="<?= $isLoggedIn ? "home.php" : "index.php"; ?>"><img src="IMG/LogoAnimado.gif" alt=""></a>
    <div class="cont">
        <input type="search" name="" id="" placeholder="Buscar">
        <div class="btns">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-search"
                viewBox="0 0 16 16">
                <path
                    d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
            </svg>
        </div>
    </div>
    <div class="icons col-2">
        <div class="col-4 ico-items">
            <?php foreach ($dtMenHead as $dmh):?>
                <a href="<?= $isLoggedIn ? $dmh['url2'] : $dmh['url']; ?>" title="<?= $dmh['nombre']; ?>">
                    <i class="<?= $dmh['icomen']; ?>"></i>
                </a>
            <?php endforeach ?>
        </div>
        <div class="inf-perfil">
            <a href="#" id="btnPrf">
                <i class="bi bi-person-circle"></i>
            </a>
            <?php include "views/vwOpcMen.php"; ?>
        </div>
    </div>
</header>
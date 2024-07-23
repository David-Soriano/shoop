<nav class="nav-men">
    <ul class="men-hrz">
        <?php if ($dtMenu) {
            foreach ($dtMenu as $dt) { ?>
                <li class="nav-item"><a class="nav-link" href="index.php?pg=<?= $pg; ?>">Nosotros</a></li>
            <?php }
        } ?>
    </ul>
</nav>
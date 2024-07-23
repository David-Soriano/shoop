<nav class="nav-men">
    <ul class="men-hrz">
        <?php if ($dtMenu) {
            foreach ($dtMenu as $dt) { ?>
                <li class="nav-item"><a class="nav-link" href="<?= $dt['url']; ?>"><?= $dt['nombre']; ?></a>
                    <?php if (!$dt['url']) { ?>
                        <ul class="men-hrz">
                            <!-- submenu -->
                        </ul>
                    <?php } ?>
                </li>
            <?php }
        } ?>
    </ul>
</nav>
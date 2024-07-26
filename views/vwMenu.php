<nav class="nav-men">
    <ul class="men-hrz">
        <?php foreach ($dtMenu as $menuItem): ?>
            <li class="nav-item">
                <a href="<?= $isLoggedIn ? $menuItem['url'] : $menuItem['url2']; ?>"><?= $menuItem['nombre'] ?></a>
                <?php if (!empty($menuItem['submenus'])): ?>
                    <ul class="men-vrt">
                        <?php foreach ($menuItem['submenus'] as $subMenuItem):?>
                            <li>
                                <a href="<?=  $subMenuItem['url2'];?>"><?= $subMenuItem['nombre'] ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>

<div class="bx-prf-opcs" id="bx-opc-prf">
    <ul>
        <?php
        if($dtMenPf){
            foreach($dtMenPf as $dt) {
                $url = $dt['url'];
                // Solo agrega idusu si requiere_idusu es 1
                if ($dt['isUser'] == 1) {
                    $url .= "&idusu=" . $_SESSION['idusu'];
                }
                ?>
                <li><a href="<?= $url; ?>"><?= $dt['nombre']; ?></a></li>
            <?php }
        }?>
    </ul>
</div>

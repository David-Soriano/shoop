<div class="bx-prf-opcs" id="bx-opc-prf">
    <ul>
        <?php if($dtMenPf){
            foreach($dtMenPf AS $dt){?>
        <li><a href="<?=$dt['url'];?>"><?=$dt['nombre'];?></a></li>
        <?php }
        }?>
    </ul>
</div>
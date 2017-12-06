<div class="map">
    <?php for ($j = 0; $j < 20; $j++) {?>
        <div class="map-row">
            <?php for ($i = 0; $i < 20; $i++) {?>
                <div class="index__background b<?=rand(1, 9);?>"></div>
            <?php } ?>
        </div>
    <?php } ?>
</div>
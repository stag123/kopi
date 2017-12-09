<?php
/**
 * @var app\models\Map[][] $mapData
 */

?>
<div class="map">
    <?php for ($j = 0; $j < count($mapData); $j++) {?>
        <div class="map-row">
            <?php for ($i = 0; $i < count($mapData[$j + 1]); $i++) {?>
                <div class="index__background <?= $mapData[$i+1][$j+1]->village ? 'village' : 'b' . $mapData[$i+1][$j+1]->type;?>">

                    <?php if ($mapData[$i+1][$j+1]->village) {?>
                    <div class="hexagon"></div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
</div>
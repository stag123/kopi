<?php
/**
 * @var app\models\Map[][] $mapData
 */
use yii\helpers\Url;

use app\assets\MapAsset;

MapAsset::register($this);
?>


<div class="map-container">
    <?php if ($y > 1) {?>
        <a class="arrow-map top" href="<?= Url::to(['map/index', 'x' => $x, 'y' => $y - 2]);?>"></a>
    <?php } ?>
    <?php if ($x > 1) {?>
    <a class="arrow-map left" href="<?= Url::to(['map/index', 'x' => $x - 2, 'y' => $y]);?>"></a>
    <?php } ?>
    <div class="map">
        <?php foreach ($mapData as $i => $mapp) {?>
            <div class="map-row">
                <?php foreach ($mapp as $j => $map ) {
                    if ($map) {

                        $myVillage = $map->village && $map->village->user_id == Yii::$app->user->getId();
                    ?>
                    <div class="map-cell <?= $myVillage ? 'my-village' : ($map->village ? 'enemy-village': '');?>">
                        <div class="selector"></div>
                        <a data-tooltip="(<?= $i;?>, <?=$j;?>)" class="index__background <?= $map->village ? 'village" href="'. ($myVillage ? Url::to(['village/view', 'id' => $map->village->id]) : Url::to(['village/enemy', 'id' => $map->village->id])) .'"' : 'b' . $map->type . '"';?>">
                        </a>
                    </div>
                    <?php } else { ?>
                        <div class="map-cell pos<?= $i;?>_<?= $j;?>">
                            <div class="selector"></div>
                            <a data-tooltip="(<?= $i;?>, <?=$j;?>)" class="index__background"></a>
                        </div>
                     <? } ?>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
    <?php if ($x < app\models\Map::SIZE - 1) {?>
    <a class="arrow-map right" href="<?= Url::to(['map/index', 'x' => $x + 2, 'y' => $y]);?>"></a>
    <?php } ?>
    <?php if ($y < app\models\Map::SIZE - 1) {?>
        <a class="arrow-map bottom" href="<?= Url::to(['map/index', 'x' => $x, 'y' => $y + 2]);?>"></a>
    <?php } ?>
</div>
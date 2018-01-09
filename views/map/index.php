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
        <a class="arrow-map top"></a>
    <?php } ?>
    <?php if ($x > 1) {?>
    <a class="arrow-map left"></a>
    <?php } ?>
    <div id="map_container" class="map">
    </div>
    <?php if ($x < app\models\Map::SIZE - 1) {?>
    <a class="arrow-map right"></a>
    <?php } ?>
    <?php if ($y < app\models\Map::SIZE - 1) {?>
        <a class="arrow-map bottom"></a>
    <?php } ?>
</div>
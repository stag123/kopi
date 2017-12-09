<?php
/**
 * @var app\models\Map[][] $mapData
 */
use yii\helpers\Url;

use app\assets\MapAsset;

MapAsset::register($this);

?>
<div class="map">
    <?php for ($j = 0; $j < count($mapData); $j++) {?>
        <div class="map-row">
            <?php for ($i = 0; $i < count($mapData[$j + 1]); $i++) {
                $map = $mapData[$i+1][$j+1];
                ?>
                <div class="map-cell <?=  $map->village && $map->village->user_id == Yii::$app->user->getId() ? 'my-village' : '';?>">
                    <div class="selector"></div>
                    <a class="index__background <?= $map->village ? 'village" href="'. Url::to(['village/view', 'id' => $map->village->id]) .'"' : 'b' . $map->type . '"';?>">
                    </a>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
</div>
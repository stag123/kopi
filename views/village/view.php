<?php

/**
 * @var app\models\Village $village
 * @var app\models\VillageMap[][] $mapData
 */
//var_dump($village);

//die();
use app\assets\VillageAsset;

VillageAsset::register($this);
?>

<div class="village-container">
    <div class="map">
        <?php foreach ($mapData as $i => $mapp) {?>
            <div class="map-row">
                <?php foreach ($mapp as $j => $map ) {
                    if ($map) {
                        ?>
                        <div class="map-cell pos<?= $i;?>_<?= $j;?> <?=  $map->buildVillage ? 'build' : '';?>">
                            <div class="selector"></div>
                            <a class="index__background <?= $map->buildVillage ? 'build" href="'. Url::to(['build/view', 'id' => $map->buildVillage->id]) .'"' : 'b' . $map->type . '"';?>">
                            </a>
                        </div>
                    <?php } else { ?>
                        <div class="map-cell pos<?= $i;?>_<?= $j;?>">
                            <div class="selector"></div>
                            <a class="index__background"></a>
                        </div>
                    <? } ?>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</div>

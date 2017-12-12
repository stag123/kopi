<?php

/**
 * @var app\components\BaseView $this
 * @var app\models\Village $village
 * @var app\models\VillageMap[][] $mapData
 */

$villageResource = $village->villageResource;

use app\assets\VillageAsset;

VillageAsset::register($this);
?>
<div class="resource-container">

    <div class="resource wood">
        <span class="count"><span class="js_wood_count"><?= $villageResource->wood;?></span> / <span class="js_wood_max">80000</span></span>
    </div>
    <div class="resource iron">
        <span class="count"><span class="js_iron_count"><?= $villageResource->iron;?></span> / <span class="js_iron_max">80000</span>
    </div>
    <div class="resource stone">
        <span class="count"><span class="js_stone_count"><?= $villageResource->stone;?></span> / <span class="js_stone_max">80000</span>
    </div>
    <div class="resource grain">
        <span class="count"><span class="js_grain_count"><?= $villageResource->grain;?></span> / <span class="js_grain_max">80000</span>
    </div>
</div>

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

    <div class="menu-left">
        Добыча ресурсов:
        <div class="resource-container">

            <div class="resource wood">
                <span class="count"><span class="js_wood_speed">100</span> в час</span>
            </div>
            <div class="resource iron">
                <span class="count"><span class="js_iron_speed">100</span> в час</span>
            </div>
            <div class="resource stone">
                <span class="count"><span class="js_stone_speed">100</span> в час</span>
            </div>
            <div class="resource grain">
                <span class="count"><span class="js_grain_speed">100</span> в час</span>
            </div>
        </div>

        Войска:
        <div class="army">Нет войск</div>
    </div>
</div>

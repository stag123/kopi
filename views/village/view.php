<?php

/**
 * @var app\components\BaseView $this
 * @var app\models\Village $village
 * @var app\models\VillageMap[][] $mapData
 */

$villageResource = $this->commandVillageResourceCalculate->execute($village);
$speedResource = $village->getResourceHour();
$stockSize = $village->getStockSize();
$granarySize = $village->getGranarySize();

use app\assets\VillageAsset;
use \app\components\village\build\models\Build;
use yii\helpers\Url;

VillageAsset::register($this);
?>
<div class="resource-container">

    <div class="resource wood">
        <span class="count"><span class="js_wood_count"><?= $villageResource->wood;?></span> / <span class="js_wood_max"><?= $stockSize;?></span></span>
    </div>
    <div class="resource iron">
        <span class="count"><span class="js_iron_count"><?= $villageResource->iron;?></span> / <span class="js_iron_max"><?= $stockSize;?></span>
    </div>
    <div class="resource stone">
        <span class="count"><span class="js_stone_count"><?= $villageResource->stone;?></span> / <span class="js_stone_max"><?= $stockSize;?></span>
    </div>
    <div class="resource grain">
        <span class="count"><span class="js_grain_count"><?= $villageResource->grain;?></span> / <span class="js_grain_max"><?= $granarySize;?></span>
    </div>
</div>

<div class="village-container">
    <div class="map js_map">
        <?php foreach ($mapData as $i => $mapp) {?>
            <div class="map-row">
                <?php foreach ($mapp as $j => $map ) {
                    if ($map) {

                        if ($map->build_id) {
                            $build = Build::GetByID($map->build_id);
                        }
                        ?>
                        <div class="map-cell">
                            <div class="selector"></div>
                            <a data-tooltip="<?= $map->build_id ? $build->name : 'Нажмите, чтобы строить';?>"
                               data-id="<?=$map->id;?>"
                               data-build-code="<?= $map->build_id ? $map->getBuild()->code : '';?>"
                               class="js_build index__background<?=$map->build_id ? ' ' .$build->code : ' b' . $map->type;?>">
                            </a>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        <?php } ?>
    </div>

    <div class="build-info js_build_info"></div>

    <div class="menu-left">
        Добыча ресурсов:
        <div class="resource-container">

            <div class="resource wood">
                <span class="count"><span class="js_wood_speed"><?= $speedResource->wood;?></span> в час</span>
            </div>
            <div class="resource iron">
                <span class="count"><span class="js_iron_speed"><?= $speedResource->iron;?></span> в час</span>
            </div>
            <div class="resource stone">
                <span class="count"><span class="js_stone_speed"><?= $speedResource->stone;?></span> в час</span>
            </div>
            <div class="resource grain">
                <span class="count"><span class="js_grain_speed"><?= $speedResource->grain;?></span> в час</span>
            </div>
        </div>

        Войска:
        <div class="army">Нет войск</div>
    </div>
</div>

<?php

/**
 * @var app\components\BaseView $this
 * @var app\models\Village $village
 * @var app\models\VillageMap[][] $mapData
 */

$villageResource = $this->commandVillageResourceCalculate->execute($village);
$villageUnits = $village->getVillageUnits();
$speedResource = $village->getResourceHour();
$stockSize = $village->getStockSize();
$granarySize = $village->getGranarySize();

use app\assets\VillageAsset;
use \app\components\village\build\models\Build;
use yii\helpers\Url;
use \app\components\village\build\unit\models\Unit;

VillageAsset::register($this);
?>
<div class="resource-container">

    <div class="resource wood">
        <span class="count"><span class="js_wood_count"><?= floor($villageResource->wood);?></span> / <span class="js_wood_max"><?= $stockSize;?></span></span>
    </div>
    <div class="resource iron">
        <span class="count"><span class="js_iron_count"><?= floor($villageResource->iron);?></span> / <span class="js_iron_max"><?= $stockSize;?></span>
    </div>
    <div class="resource stone">
        <span class="count"><span class="js_stone_count"><?= floor($villageResource->stone);?></span> / <span class="js_stone_max"><?= $stockSize;?></span>
    </div>
    <div class="resource grain">
        <span class="count"><span class="js_grain_count"><?= floor($villageResource->grain);?></span> / <span class="js_grain_max"><?= $granarySize;?></span>
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
                        <div class="map-cell<?=$map->status === \app\models\VillageMap::STATUS_BUILDING ? ' building': '';?>">
                            <div class="selector"></div>
                            <a href="#map<?=$map->id;?>" data-tooltip="<?= ($map->status === \app\models\VillageMap::STATUS_BUILDING ? 'Идет строительство...' : ($map->build_id ? $build->name : 'Нажмите, чтобы строить'));?>"
                               data-id="<?=$map->id;?>"
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
        <div class="red-info js_red_info"></div>
        <div class="green-info js_green_info"></div>
        <div class="yellow-info js_yellow_info"></div>
        Добыча ресурсов:
        <div class="resource-container">

            <div class="resource wood">
                <span class="count"><span class="js_wood_speed"><?= floor($speedResource->wood);?></span> в час</span>
            </div>
            <div class="resource iron">
                <span class="count"><span class="js_iron_speed"><?= floor($speedResource->iron);?></span> в час</span>
            </div>
            <div class="resource stone">
                <span class="count"><span class="js_stone_speed"><?= floor($speedResource->stone);?></span> в час</span>
            </div>
            <div class="resource grain">
                <span class="count"><span class="js_grain_speed"><?= floor($speedResource->grain);?></span> в час</span>
            </div>
        </div>

        Войска:
        <div class="army">
            <?php foreach(Unit::GetTypes() as $type) {
                if ($villageUnits->{$type}) { ?>
                    <div class="unit <?= $type; ?>"><?= $villageUnits->{$type}; ?></div>
                <?php }
            }?>
        </div>
    </div>
</div>

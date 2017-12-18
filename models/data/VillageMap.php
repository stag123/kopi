<?php

namespace app\models\data;

use \app\models\VillageMap as VillageMapModel;
use \app\models\Village;
use Yii;

/**
 * @inheritdoc
 */
class VillageMap extends VillageMapModel
{

    const STATUS_BUILD = 1;
    const STATUS_FREE = 2;

    const SIZE = 5;
    const RESOURCE_COUNT = 3;

    const TYPE_IRON = 1;
    const TYPE_STONE = 2;
    const TYPE_WOOD = 3;
    const TYPE_GRAIN = 4;
    const TYPE_EARTH = 5;

    public static function generate($village_id, $grainCount = self::RESOURCE_COUNT, $woodCount = self::RESOURCE_COUNT, $ironCount = self::RESOURCE_COUNT, $stoneCount = self::RESOURCE_COUNT) {
        $map = array_merge(
            array_fill(0, $grainCount, self::TYPE_GRAIN),
            array_fill(0, $woodCount, self::TYPE_WOOD),
            array_fill(0, $ironCount, self::TYPE_IRON),
            array_fill(0, $stoneCount, self::TYPE_STONE),
            array_fill(0, self::SIZE * self::SIZE - $grainCount - $woodCount - $ironCount - $stoneCount, self::TYPE_EARTH)
        );

        shuffle($map);

        for ($i = 0; $i < self::SIZE; $i++) {
            for ($j = 0; $j < self::SIZE; $j++) {
                $villageMap = new self;
                $villageMap->x = $i + 1;
                $villageMap->y = $j + 1;
                $villageMap->village_id = $village_id;
                $villageMap->type = array_pop($map);
                $villageMap->status = self::STATUS_FREE;
                $villageMap->save();
            }
        }
    }


    public static function getByVillage(Village $village) {
        $maps = $village->villageMaps;

        $mapData = [];
        foreach($maps as $map) {
            $mapData[$map->y][$map->x] = $map;
        }

        $data = [];
        for ($i = 1; $i <= self::SIZE; $i++) {
            for ($j = 1; $j <= self::SIZE; $j++) {
                $data[$i][$j] = isset($mapData[$i][$j]) ? $mapData[$i][$j]: null;
            }
        }
        return $data;
    }
}

<?php

namespace app\components\village\build;

use app\components\BaseComponent;
use app\models\Village;
use app\models\BuildType as BuildTypeModel;
use app\models\data\Build;
use app\models\data\VillageMap;


class BuildFactory extends BaseComponent {

    public function create(BuildTypeModel $type, $level) {
        if ($type->id === Build::ID_GRAIN_FARM) {
            return BuildData::getGrainFarm($level);
        }
        if ($type->id === Build::ID_IRON_FARM) {
            return BuildData::getIronFarm($level);
        }
        if ($type->id === Build::ID_ARMY) {
            return BuildData::getArmy($level);
        }
        if ($type->id === Build::ID_STOCK) {
            return BuildData::getStock($level);
        }
        if ($type->id === Build::ID_GRANARY) {
            return BuildData::getGranary($level);
        }
        if ($type->id === Build::ID_STONE_FARM) {
            return BuildData::getStoneFarm($level);
        }
        if ($type->id === Build::ID_WOOD_FARM) {
            return BuildData::getWoodFarm($level);
        }
    }

    public function createResource($mapType, $level = 1) {
        if ($mapType === VillageMap::TYPE_GRAIN) {
            return BuildData::getGrainFarm($level);
        }
        if ($mapType === VillageMap::TYPE_IRON) {
            return BuildData::getIronFarm($level);
        }
        if ($mapType === VillageMap::TYPE_STONE) {
            return BuildData::getStoneFarm($level);
        }
        if ($mapType === VillageMap::TYPE_WOOD) {
            return BuildData::getWoodFarm($level);
        }
    }

    public function createForVillage(Village $village) {
        $builds = [
            Build::ID_STOCK => BuildData::getStock(1),
            Build::ID_GRANARY => BuildData::getGranary(1),
            Build::ID_ARMY => BuildData::getArmy(1)
        ];

        $maps = $village->villageMaps;

        foreach($maps as $map) {
            if ($map->build_id) {
                unset($builds[$map->build_id]);
            }
        }

        return $builds;
    }
}
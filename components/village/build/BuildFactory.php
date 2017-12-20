<?php

namespace app\components\village\build;

use app\components\BaseComponent;
use app\components\village\build\models\Army;
use app\components\village\build\models\BuildInfo;
use app\components\village\build\models\GrainFarm;
use app\components\village\build\models\Granary;
use app\components\village\build\models\IronFarm;
use app\components\village\build\models\Stock;
use app\components\village\build\models\StoneFarm;
use app\components\village\build\models\WoodFarm;
use app\models\Village;
use app\components\village\build\models\Build;
use app\models\VillageMap;


class BuildFactory extends BaseComponent {

    /**
     * @param $build_id
     * @param $level
     * @return BuildInfo
     */
    public function createForBuild($build_id, $level) {
        if ($build_id === Build::ID_GRAIN_FARM) {
            return GrainFarm::getByLevel($level);
        }
        if ($build_id === Build::ID_IRON_FARM) {
            return IronFarm::getByLevel($level);
        }
        if ($build_id === Build::ID_ARMY) {
            return Army::getByLevel($level);
        }
        if ($build_id === Build::ID_STOCK) {
            return Stock::getByLevel($level);
        }
        if ($build_id === Build::ID_GRANARY) {
            return Granary::getByLevel($level);
        }
        if ($build_id === Build::ID_STONE_FARM) {
            return StoneFarm::getByLevel($level);
        }
        if ($build_id === Build::ID_WOOD_FARM) {
            return WoodFarm::getByLevel($level);
        }
    }

    public function createForResource($mapType, $level = 1) {
        if ($mapType === VillageMap::TYPE_GRAIN) {
            return GrainFarm::getByLevel($level);
        }
        if ($mapType === VillageMap::TYPE_IRON) {
            return IronFarm::getByLevel($level);
        }
        if ($mapType === VillageMap::TYPE_STONE) {
            return StoneFarm::getByLevel($level);
        }
        if ($mapType === VillageMap::TYPE_WOOD) {
            return WoodFarm::getByLevel($level);
        }
    }

    public function createForVillage(Village $village) {
        $builds = [
            Build::ID_STOCK => Stock::getByLevel(1),
            Build::ID_GRANARY => Granary::getByLevel(1),
            Build::ID_ARMY => Army::getByLevel(1)
        ];

        $maps = $village->villageMaps;

        foreach($maps as $map) {
            if ($map->build_id) {
                unset($builds[$map->build_id]);
            }
        }

        return array_values($builds);
    }
}
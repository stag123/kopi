<?php

namespace app\components\village\resource;

use app\components\BaseComponent;
use app\models\Resource as ResourceModel;
use app\models\Village;
use app\models\data\VillageMap;


class Query extends BaseComponent {
    const BASE_RESOURCE_GROW = 1000;
    /**
     * Получить у деревни добычу в час
     * @param Village $village
     * @return ResourceModel
     */
    public function fetchHour(Village $village) {
        $resource = new ResourceModel;
        foreach($village->villageMaps as $map) {
            if ($map->type === VillageMap::TYPE_GRAIN) {
                $resource->grain += self::BASE_RESOURCE_GROW;
            }
            if ($map->type === VillageMap::TYPE_IRON) {
                $resource->iron += self::BASE_RESOURCE_GROW * 2;
            }
            if ($map->type === VillageMap::TYPE_STONE) {
                $resource->stone += self::BASE_RESOURCE_GROW * 3;
            }
            if ($map->type === VillageMap::TYPE_WOOD) {
                $resource->wood += self::BASE_RESOURCE_GROW * 4;
            }
        }
        return $resource;
    }

    public function fetchActual(Village $village) {
        return $this->commandVillageResourceCalculate->execute($village);
    }
}
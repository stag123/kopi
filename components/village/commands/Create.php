<?php

namespace app\components\village\commands;

use app\components\BaseComponent;
use app\models\Resources;
use app\models\Map;
use app\models\Units;
use app\models\User;
use app\models\Village;
use app\models\VillageMap;
use yii\web\BadRequestHttpException;

class Create extends BaseComponent {

    public function execute(User $user) {
        $map = Map::findFree();
        if (!$map) {
            throw new BadRequestHttpException("Map is full");
        }
        $map->status = Map::STATUS_VILLAGE;
        $map->save();

        $model = new Resources;
        $model->grain = Village::NEW_VILLAGE_RESOURCE;
        $model->wood = Village::NEW_VILLAGE_RESOURCE;
        $model->stone = Village::NEW_VILLAGE_RESOURCE;
        $model->iron = Village::NEW_VILLAGE_RESOURCE;

        $resource_group_id = $model->save();

        $village = new Village();
        $village->map_id = $map->id;
        $village->user_id = $user->id;
        $village->village_resources_id = $resource_group_id;
        $village->resources_updated_at = round(microtime(true) * 1000);
        if (!$village->save()) {
            throw new BadRequestHttpException("Erro create village " . serialize($village->errors));
        }

        VillageMap::generate($village->id);
    }
}
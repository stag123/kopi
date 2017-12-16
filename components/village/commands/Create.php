<?php

namespace app\components\village\commands;

use app\components\BaseComponent;
use app\models\Resource;
use app\models\Map;
use app\models\User;
use app\models\Village;
use app\models\data\VillageMap;
use yii\web\BadRequestHttpException;

class Create extends BaseComponent {

    const NEW_VILLAGE_RESOURCE = 800;

    public function execute(User $user) {
        $map = Map::findFree();
        if (!$map) {
            throw new BadRequestHttpException("Map is full");
        }
        $map->status = Map::STATUS_VILLAGE;
        $map->save();

        $model = new Resource;
        $model->grain = self::NEW_VILLAGE_RESOURCE;
        $model->wood = self::NEW_VILLAGE_RESOURCE;
        $model->stone = self::NEW_VILLAGE_RESOURCE;
        $model->iron = self::NEW_VILLAGE_RESOURCE;

        $resource_group_id = $model->save();

        $village = new Village();
        $village->map_id = $map->id;
        $village->user_id = $user->id;
        $village->village_resource_id = $resource_group_id;
        $village->resource_updated_at = round(microtime(true) * 1000);
        $village->save();

        VillageMap::generate($village->id);
    }
}
<?php

namespace app\components\village\commands;

use app\components\BaseComponent;
use app\components\resource\Model as ResourceModel;
use app\models\Map;
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

        $model = new ResourceModel;
        $model->grain = 800;
        $model->wood = 800;
        $model->stone = 800;
        $model->iron = 800;

        $resource_group_id = $this->commandResourceCreate->execute($model);

        $village = new Village();
        $village->map_id = $map->id;
        $village->user_id = $user->id;
        $village->village_resource_id = $resource_group_id;
        $village->save();

        VillageMap::generate($village->id);
    }
}
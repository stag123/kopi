<?php

namespace app\components\village\commands;

use app\components\BaseComponent;
use app\models\Map;
use app\models\User;
use app\models\Village;
use app\types\ResourceType;
use yii\web\BadRequestHttpException;

class Create extends BaseComponent {

    public function execute(User $user) {
        $map = Map::findFree();
        if (!$map) {
            throw new BadRequestHttpException("Map is full");
        }
        $map->status = Map::STATUS_VILLAGE;
        $map->save();

        $resource_group_id = $this->commandResourceCreate->execute([
            ResourceType::GRAIN => 800,
            ResourceType::WOOD => 800,
            ResourceType::STONE => 800,
            ResourceType::IRON => 800
        ]);

        $village = new Village();
        $village->map_id = $map->id;
        $village->user_id = $user->id;
        $village->village_resource_id = $resource_group_id;
        $village->save();
    }
}
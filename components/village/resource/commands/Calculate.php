<?php

namespace app\components\village\resource\commands;

use app\components\BaseComponent;
use app\models\Village;
use yii\web\BadRequestHttpException;


class Calculate extends BaseComponent {

    /**
     * Пересчет ресурсов в деревне
     * @param Village $village
     */
    public function execute(Village $village) {
        $resource = $village->getResourceHour();
        $villageResource = $village->villageResources;
        $time = round(microtime(true) * 1000);
        $time_left = $time - $village->resources_updated_at;

        $villageResource->grain += $resource->grain / 3600000 * $time_left;
        $villageResource->wood += $resource->wood / 3600000 * $time_left;
        $villageResource->iron += $resource->grain / 3600000 * $time_left;
        $villageResource->stone += $resource->stone / 3600000 * $time_left;

        $grainMax = $village->getGranarySize();
        $resourceMax = $village->getStockSize();

        $villageResource->grain = min($villageResource->grain, $grainMax);
        $villageResource->wood = min($villageResource->wood, $resourceMax);
        $villageResource->iron = min($villageResource->iron, $resourceMax);
        $villageResource->stone = min($villageResource->stone, $resourceMax);

        $village->resources_updated_at = $time;
        if (!$villageResource->save() || !$village->save()) {
            throw new BadRequestHttpException("Error calculate resource " . serialize($villageResource->errors));
        }

        return $villageResource;
    }
}
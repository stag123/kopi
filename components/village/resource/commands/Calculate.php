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
        $resource = $this->villageResourceQuery->fetchHour($village);
        $villageResource = $village->villageResource;
        $time = round(microtime(true) * 1000);
        $time_left = $time - $village->resource_updated_at;

        $villageResource->grain += $resource->grain / 3600000 * $time_left;
        $villageResource->wood += $resource->wood / 3600000 * $time_left;
        $villageResource->iron += $resource->grain / 3600000 * $time_left;
        $villageResource->stone += $resource->stone / 3600000 * $time_left;

        $village->resource_updated_at = $time;
        if (!$villageResource->save() || !$village->save()) {
            throw new BadRequestHttpException("Error calculate resource " . serialize($villageResource->errors));
        }

        return $villageResource;
    }
}
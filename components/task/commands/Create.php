<?php

namespace app\components\task\commands;

use app\components\BaseComponent;
use app\components\village\build\models\Build;
use app\components\village\build\unit\models\Unit;
use app\models\Map;
use app\models\Resources;
use app\models\Task;
use app\models\TaskBuild;
use app\models\TaskUnit;
use app\models\TaskAttack;
use app\models\TaskTrade;
use app\models\Units;
use app\models\Village;
use app\models\VillageMap;
use yii\web\BadRequestHttpException;


class Create extends BaseComponent
{

    const STATUS_CREATE = 1;
    const STATUS_DONE = 2;

    private function newTask($village_from_id, $village_to_id, $duration) {
        $task = new Task();
        $task->status = self::STATUS_CREATE;
        $task->duration = $duration;
        $task->village_from_id = $village_from_id;
        $task->village_to_id = $village_to_id;
        if (!$task->save()) {
            throw new BadRequestHttpException("Error create task");
        }

        return $task;
    }

    public function createBuild(VillageMap $map, Build $build) {
        $level = ($map->level ?: 0) + 1;
        $buildData = $this->buildFactory->createForBuild($build->id, $level);
        if (!$map->village->villageResources->greaterThen($buildData->price)) {
            throw new BadRequestHttpException("Недотаточно ресурсов");
        }

        $map->village->villageResources->remove($buildData->price);

        $task = $this->newTask($map->village_id, $map->village_id, $buildData->buildTime);

        $taskBuild = new TaskBuild();
        $taskBuild->village_map_id = $map->id;
        $taskBuild->task_id = $task->id;
        $taskBuild->build_id = $build->id;
        $taskBuild->level = $level;

        $taskBuild->save();

        if (!$taskBuild->save()) {
            throw new BadRequestHttpException("Error create build task");
        }

        $map->startBuild();
    }

    public function createUnit(Village $village, Unit $unit, $count) {
        $price = $unit->price->multiply($count);
        if (!$village->villageResources->greaterThen($price)) {
            throw new BadRequestHttpException("Недотаточно ресурсов");
        }

        if ($count <= 0) {
            throw new BadRequestHttpException("Недопустимое количество");
        }

        $village->villageResources->remove($price);

        $task = $this->newTask($village->id, $village->id, $unit->buildTime);

        $taskUnit = new TaskUnit();
        $taskUnit->count = $count;
        $taskUnit->unit_id = $unit->id;
        $taskUnit->task_id = $task->id;

        if (!$taskUnit->save()) {
            throw new BadRequestHttpException("Error create unit task");
        }
    }

    public function createAttack(Units $units, Village $villageFrom, Village $villageTo) {
        if (!$villageFrom->getVillageUnits()->greaterThen($units)) {
            throw new BadRequestHttpException("Недотаточно войнов");
        }
        $villageFrom->getVillageUnits()->remove($units);

        $distance = Map::getDistance($villageFrom->map, $villageTo->map);
        $time = ceil($distance / $units->getSmallestSpeed() * 3600);

        $task = $this->newTask($villageFrom->id, $villageTo->id, $time);

        $taskAttack = new TaskAttack();
        $taskAttack->units = $units;
        $taskAttack->task_id = $task->id;
        $taskAttack->resources_id = Resources::CreateOne()->id;
        if (!$taskAttack->save()) {
            throw new BadRequestHttpException("Error create attack task");
        }
    }
}
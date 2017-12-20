<?php

namespace app\components\task\commands;

use app\components\BaseComponent;
use app\components\village\build\models\Build;
use app\models\Task;
use app\models\TaskBuild;
use app\models\TaskUnit;
use app\models\TaskAttack;
use app\models\TaskTrade;
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

    public function createUnit() {

    }

    public function createAttack() {

    }
}
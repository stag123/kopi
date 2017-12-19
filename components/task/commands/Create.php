<?php

namespace app\components\task\commands;

use app\components\BaseComponent;
use app\components\village\build\BuildData;
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

    private function newTask($duration) {
        $task = new Task();
        $task->status = self::STATUS_CREATE;
        $task->duration = $duration;
        if (!$task->save()) {
            throw new BadRequestHttpException("Error create task");
        }

        return $task;
    }

    public function createBuild(VillageMap $map, Build $build) {
        $level = ($map->level ?: 0) + 1;
        $task = $this->newTask(BuildData::GetByTypeAndLevel($build->id, $level)->build_time);

        $taskBuild = new TaskBuild();
        $taskBuild->village_id = $map->village_id;
        $taskBuild->village_map_id = $map->id;
        $taskBuild->task_id = $task->id;
        $taskBuild->build_id = $build->id;
        $taskBuild->level = $level;

        $taskBuild->save();

        if (!$taskBuild->save()) {
            throw new BadRequestHttpException("Error create build task");
        }

        $map->status = VillageMap::STATUS_BUILDING;
        $map->save();
    }

    public function createUnit() {

    }

    public function createAttack() {

    }
}
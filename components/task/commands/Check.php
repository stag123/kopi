<?php

namespace app\components\task\commands;

use app\components\BaseComponent;
use app\components\village\build\models\Build;
use app\components\village\build\unit\models\Unit;
use app\models\Task;
use app\models\TaskBuild;
use app\models\TaskUnit;
use app\models\TaskAttack;
use app\models\TaskTrade;
use app\models\VillageMap;
use yii\db\Expression;
use yii\web\BadRequestHttpException;


class Check extends BaseComponent
{

    const TIME_EXECUTE = 10;

    public function execute() {
        $worker = round(microtime(true) * 1000) % 10000 + mt_rand(1, 1000);

        $deleted = Task::freeTasks(self::TIME_EXECUTE);

        $this->logger->info('Deleted tasks: ' . $deleted);

        $tasks = Task::getTasks($worker, self::TIME_EXECUTE);

        $count = count($tasks);

        $this->logger->info('Count tasks: ' . $count);
        while($count) {
            foreach ($tasks as $task) {

                $dateTime = date_create_from_format("Y-m-d H:i:s", $task->created_at);


                $this->logger->info('Start task id: ' . $task->id);
                $this->logger->info('Created at: ' . $dateTime->getTimestamp() . ' date: ' . date('Y-m-d H:i:s',  $dateTime->getTimestamp()));
                $this->logger->info('Time' . time() . ' date: '. date('Y-m-d H:i:s', time()));
                if ($dateTime->getTimestamp() + $task->duration <= time() && $task->status === Task::STATUS_PROGRESS) {
                    if ($task->taskBuild) {
                        $task->taskBuild->villageMap->build($task->taskBuild->build_id, $task->taskBuild->level);
                    }else if ($task->taskUnit) {
                        $unit = Unit::GetByID($task->taskUnit->unit_id);
                        $village = $task->villageFrom;
                        $villageUnits = $village->getVillageUnits();
                        $villageUnits->{$unit->code} += 1;
                        $this->logger->info('Count units: ' . $villageUnits->{$unit->code});
                        $villageUnits->save();
                        if (!$villageUnits->save()) {
                            $this->logger->error(serialize($villageUnits));
                            exit();
                        }
                        $task->taskUnit->count -= 1;
                        if ($task->taskUnit->count > 0) {
                            $task->created_at = date('Y-m-d H:i:s', $dateTime->getTimestamp() + $task->duration);
                            $task->status = Task::STATUS_NEW;
                            $task->taskUnit->save();
                            $task->save();
                            $count--;
                            continue;
                        }
                    }
                    $this->logger->info('Done task: ' . $task->id);
                    $task->done();
                    $count--;
                } else {
                    $this->logger->info('Left time: ' . ($dateTime->getTimestamp() + $task->duration - time()));
                }
            }
            usleep(500);
            $this->logger->info('sleep 500ms');
        }
    }
}
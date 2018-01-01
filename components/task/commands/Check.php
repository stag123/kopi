<?php

namespace app\components\task\commands;

use app\components\BaseComponent;
use app\components\village\build\models\Build;
use app\components\village\build\unit\models\Unit;
use app\models\Report;
use app\models\Resources;
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

    public function completeTask(Task $task) {

        $dateTime = date_create_from_format("Y-m-d H:i:s", $task->created_at);

        switch ($task->type) {
            case Task::TYPE_BUILD:
                $task->taskBuild->villageMap->build($task->taskBuild->build_id, $task->taskBuild->level);
                break;
            case Task::TYPE_BUILD_UNIT:
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
                    return true;
                }
                break;
            case Task::TYPE_ATTACK:
                if ($task->taskAttack->units->village_id == $task->village_to_id) {
                    $this->commandVillageResourceCalculate->execute($task->villageFrom);
                    $task->villageTo->villageResources->add($task->taskAttack->resources);
                    $task->villageTo->getVillageUnits()->add($task->taskAttack->units);
                } else {
                    $def = $task->villageTo->getVillageUnits();
                    $off = $task->taskAttack->units;
                    $offStart = $off->toArray();
                    $defStart = $def->toArray();
                    $resourceStart = $task->villageTo->villageResources->toArray();

                    $attack = $off->getAcrherAttack() + $off->getHorseAttack() + $off->getAttack();

                    $defence = $def->getArcherDefence() * $off->getAcrherAttack() / $attack +
                        $def->getHorseDefence() * $off->getHorseAttack() / $attack +
                        $def->getDefence() * $off->getAttack() / $attack;

                    $this->logger->info('Attack/ Defence: ' . $attack . '/' . $defence);

                    if ($attack > $defence) {
                        $def->remove($def);
                        $off->removePercent($defence / $attack);
                        $this->commandVillageResourceCalculate->execute($task->villageTo);
                        $resource = $task->villageTo->villageResources->steal($off->getBag());
                        $resource->save();
                        $this->logger->info('Bag: ' . $off->getBag());
                        $this->logger->info('Off after attack: ' . $off);
                        $this->logger->info('Village resource: ' . $task->villageTo->villageResources);
                        $this->logger->info('Resource steal: ' . $resource);

                        $damage = $off->getDamage();
                        $startBuild = $endBuild = null;
                        if ($damage > 0) {
                            list($startBuild, $endBuild) = $task->villageTo->damage($damage);
                        }
                        $this->logger->info('Damage ' . $damage);
                    } else {
                        $resource = new Resources();
                        $off->remove($off);
                        $def->removePercent($defence / $attack);
                    }

                    $report = new Report();
                    $report->user_id = $task->villageFrom->user_id;
                    $report->village_id = $task->village_from_id;
                    $report->title = 'Нападение на ' . $task->villageTo->name;
                    $report->type = Report::TYPE_ATTACK;
                    $report->details = json_encode(
                        [
                            'offStart' => $offStart,
                            'defStart' => $defStart,
                            'resourceStart' => $resourceStart,
                            'buildStart' => $startBuild->toArray(),
                            'off' => $off->toArray(),
                            'def' => $def->toArray(),
                            'resource' => $resource->toArray(),
                            'build' => $endBuild->toArray()
                        ]
                    );
                    $report->save();

                    $report = new Report();
                    $report->user_id = $task->villageTo->user_id;
                    $report->village_id = $task->village_to_id;
                    $report->title = 'Нападение от ' . $task->villageFrom->name;
                    $report->type = Report::TYPE_DEFENCE;
                    $report->details = json_encode(
                        [
                            'offStart' => $offStart,
                            'defStart' => $defStart,
                            'resourceStart' => $resourceStart,
                            'off' => $off->toArray(),
                            'def' => $def->toArray(),
                            'resource' => $resource->toArray(),
                        ]
                    );
                    $report->save();

                    $this->logger->info('Report saved');

                    if ($off->exist()) {
                        $task->taskAttack->resources_id = $resource->id;
                        $this->logger->info('Move back');
                        $task->created_at = date('Y-m-d H:i:s', $dateTime->getTimestamp() + $task->duration);
                        $task->status = Task::STATUS_NEW;
                        list($task->village_from_id, $task->village_to_id) = array($task->village_to_id, $task->village_from_id);
                        $task->taskAttack->save();
                        $task->save();
                        return true;
                    }
                }
                break;
        }
        $this->logger->info('Done task: ' . $task->id);
        $task->done();
        return true;
    }

    public function execute() {
        $worker = round(microtime(true) * 1000) % 10000 + mt_rand(1, 1000);

        $lostTasks = Task::getLostTasks($worker);

        foreach($lostTasks as $task) {
            $this->completeTask($task);
        }
        $this->logger->info('Lost tasks: ' . count($lostTasks));

        
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
                    if ($this->completeTask($task)) {
                        $count--;
                    }
                } else {
                    $this->logger->info('Left time: ' . ($dateTime->getTimestamp() + $task->duration - time()));
                }
            }
            usleep(500);
            $this->logger->info('sleep 500ms');
        }
    }
}
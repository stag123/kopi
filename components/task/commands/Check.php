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


class Check extends BaseComponent
{

    public function execute() {
    }
}
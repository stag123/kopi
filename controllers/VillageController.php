<?php

namespace app\controllers;

use app\components\village\build\models\Build;
use app\models\Task;
use app\models\Village;
use app\models\VillageMap;
use yii\helpers\Url;


class VillageController extends BaseController
{
    /**
    * Displays homepage.
    *
    * @return string
    */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionView()
    {
        $village = Village::findOne(['id' => $this->request->get('id')]);
        $mapData = VillageMap::getByVillage($village);

        $this->initials['villageId'] = $village->id;
        $this->initials['tasks'] = Task::getVillageTasks($village->id);
        return $this->render('view', ['village' => $village, 'mapData' => $mapData]);
    }

 /*   public function actionStat() {
        $tasks = Task::getVillageTasks($this->ajaxData['id']);
        return $this->asJson($tasks);
    }*/

    public function actionBuildList() {
        $data = [];
        $map = VillageMap::GetByID($this->ajaxData['mapId']);
        if ($map->build_id) {
            $build = $this->buildFactory->createForBuild($map->build_id, $map->level + 1);
            if ($build) {
                $data = [$build->toArray()];
            }
        } else if ($map->type !== VillageMap::TYPE_EARTH) {
            $build = $this->buildFactory->createForResource($map->type);
            if ($build) {
                $data = [$build->toArray()];
            }
        } else {
            $data = $this->buildFactory->createForVillage($map->village);
        }
        return $this->asJson($data);
    }

    public function actionBuild() {
        $mapId = $this->request->get('mapId');
        $buildId = $this->request->get('buildId');

        $map = VillageMap::GetByID($mapId);
        $build = Build::GetByID($buildId);

        $this->commandTaskCreate->createBuild($map, $build);
        $this->redirect(Url::to(["village/view", "id" => $map->village_id]));
    }
}
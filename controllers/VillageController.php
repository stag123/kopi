<?php

namespace app\controllers;

use app\components\village\build\models\Build;
use app\components\village\build\unit\models\Unit;
use app\models\Task;
use app\models\Units;
use app\models\Village;
use app\models\VillageMap;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;


class VillageController extends BaseController
{
    public $enableCsrfValidation = false;
    /**
    * Displays homepage.
    *
    * @return string
    */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function checkAccess(Village $village = null) {
        if (!$this->currentUser) {
            throw new BadRequestHttpException("Пожалуйста, авторизйтесь");
        }

        if (!$village) {
            throw new BadRequestHttpException("Деревня не найдена");
        }

        if ($village->user_id !== $this->currentUser->id) {
            throw new BadRequestHttpException("Нет прав доступа");
        }
    }

    public function actionView()
    {
        $village = Village::findOne(['id' => $this->request->get('id')]);

        $this->checkAccess($village);

        $mapData = VillageMap::getByVillage($village);

        $this->initials['villageId'] = $village->id;
        $this->initials['tasks'] = Task::getVillageTasks($village->id);
        $this->initials['villageResource'] = $village->villageResources->toArray();
        return $this->render('view', ['village' => $village, 'mapData' => $mapData]);
    }

    public function actionEnemy()
    {
        $village = Village::findOne(['id' => $this->request->get('id')]);

        if ($village->user_id === $this->currentUser->id) {
            throw new BadRequestHttpException("Error view own village as enemy");
        }

        /**
         * @var Village $fromVillage
         */
        $fromVillage = $this->currentUser->getVillage();

        $this->initials['villageFromId'] = $fromVillage->id;
        $this->initials['villageToId'] = $village->id;

        $this->initials['units'] = $fromVillage->getVillageUnits()->toNumbers();
        return $this->render('enemy', ['village' => $village]);
    }

 /*   public function actionStat() {
        $tasks = Task::getVillageTasks($this->ajaxData['id']);
        return $this->asJson($tasks);
    }*/

    public function actionBuildList() {
        $data = [];
        $map = VillageMap::GetByID($this->ajaxData['mapId']);

        if (!$map) {
            throw new BadRequestHttpException("Error");
        }
        $this->checkAccess($map->village);

        if ($map->build_id) {
            $currentBuild = $this->buildFactory->createForMap($map);
            $data = ['currentBuild' => $currentBuild];
            $build = $this->buildFactory->createForBuild($map->build_id, $map->level + 1);
            if ($build) {
                $data['nextBuild'] = $build;
            }
        } else if ($map->type !== VillageMap::TYPE_EARTH) {
            $build = $this->buildFactory->createForResource($map->type);
            if ($build) {
                $data = ['builds' => [$build]];
            }
        } else {
            $builds = $this->buildFactory->createForVillage($map->village);
            if ($builds) {
                $data = ['builds' => $builds];
            }
        }
        return $this->asJson($data);
    }

    public function actionBuild() {
        $mapId = $this->request->get('mapId');
        $buildId = $this->request->get('buildId');

        $map = VillageMap::GetByID($mapId);
        $build = Build::GetByID($buildId);

        if (!$map) {
            throw new BadRequestHttpException("Map not found");
        }
        $this->checkAccess($map->village);

        // Чтобы это убрать нужно добавить проверку на активные таски при выборе строительства
        if (Task::getVillageTasks($map->village_id)) {
            throw new BadRequestHttpException("Все строители сейчас заняты");
        }
        $this->commandTaskCreate->createBuild($map, $build);
        $this->redirect(Url::to(["village/view", "id" => $map->village_id]));
    }

    public function actionBuildUnits() {
        $mapId = $this->request->post('mapId');
        $unitId = $this->request->post('unitId');
        $count = $this->request->post('count');
        $map = VillageMap::GetByID($mapId);

        if (!$map) {
            throw new BadRequestHttpException("Map not found");
        }
        $this->checkAccess($map->village);

        $this->commandTaskCreate->createUnit($map->village, Unit::GetByID($unitId), (int) $count);

        $this->redirect(Url::to(["village/view", "id" => $map->village_id]) . '#map' .$mapId);
    }

    public function actionAttack() {
        $villageFromId = (int) $this->request->post('villageFromId');
        $villageToId = (int) $this->request->post('villageToId');

        $villageFrom = Village::GetByID($villageFromId);
        $this->checkAccess($villageFrom);
        $villageTo = Village::GetByID($villageToId);

        $units = new Units();
        $units->setAttributes($this->request->post('units'));
        $units->village_id = $villageFromId;

        if (!$units->validate()) {
            throw new BadRequestHttpException("Error units " . serialize($units->errors));
        }

        $this->commandTaskCreate->createAttack($units, $villageFrom, $villageTo);
        $this->redirect(Url::to(["village/view", "id" => $villageFrom->id]));
    }
}
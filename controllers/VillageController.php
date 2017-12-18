<?php

namespace app\controllers;

use app\models\Village;
use app\models\data\VillageMap;


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
        return $this->render('view', ['village' => $village, 'mapData' => $mapData]);
    }

    public function actionBuildList() {
        $data = [];
        $map = VillageMap::GetByID($this->ajaxData['mapId']);
        if ($map->build_id) {
            $build = $this->buildFactory->create($map->build->type, $map->build->level + 1);
            if ($build) {
                $data = [$build->toArray()];
            }
        } else if ($map->type !== VillageMap::TYPE_EARTH) {
            $build = $this->buildFactory->createResource($map->type);
            if ($build) {
                $data = [$build->toArray()];
            }
        } else {
            $data = $this->buildFactory->createForVillage($map->village);
        }
        return $this->asJson($data);
    }
}
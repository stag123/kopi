<?php

namespace app\controllers;

use app\models\Village;
use app\models\VillageMap;


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
        $village = Village::findOne(['id' => \Yii::$app->request->get('id')]);
        $mapData = VillageMap::getByVillage($village);
        return $this->render('view', ['village' => $village, 'mapData' => $mapData]);
    }
}
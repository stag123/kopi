<?php

namespace app\controllers;

use app\models\Village;


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
        return $this->render('view', ['village' => $village]);
    }
}
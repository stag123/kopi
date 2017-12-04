<?php

namespace app\controllers;

use yii\web\Controller;


class VillageController extends Controller
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

    public function buildAction()
    {

    }
}
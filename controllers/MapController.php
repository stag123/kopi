<?php

namespace app\controllers;

use yii\web\BadRequestHttpException;
use yii\web\Controller;
use app\models\Map;

class MapController extends Controller
{
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $x = \Yii::$app->request->get('x');
        $y = \Yii::$app->request->get('y');

        if (!Map::check($x, $y)) {
            throw new BadRequestHttpException("Error map position");
        }

        $mapData = Map::getPart($x, $y);

        return $this->render('index', ['mapData' => $mapData, 'x' => (int) $x, 'y' => (int) $y]);
    }
}
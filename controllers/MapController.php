<?php

namespace app\controllers;

use yii\web\BadRequestHttpException;
use app\models\Map;

class MapController extends BaseController
{
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $x = $this->request->get('x');
        $y = $this->request->get('y');

        if (!Map::check($x, $y)) {
            throw new BadRequestHttpException("Error map position");
        }

        $mapData = Map::getPart($x, $y);

        return $this->render('index', ['mapData' => $mapData, 'x' => (int) $x, 'y' => (int) $y]);
    }
}
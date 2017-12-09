<?php

namespace app\controllers;

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
        $maps = Map::find()->with('village')->all();
        $mapData = [];
        foreach($maps as $map) {
            $mapData[$map->x][$map->y] = $map;
        }
        return $this->render('index', ['mapData' => $mapData]);
    }
}
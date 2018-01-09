<?php

namespace app\controllers;

use yii\web\BadRequestHttpException;
use app\models\Map;
use yii\helpers\Url;

class MapController extends BaseController
{
    public $enableCsrfValidation = false;
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

        $this->initials['x'] = (int) $x;
        $this->initials['y'] = (int) $y;

        return $this->render('index', ['x' => (int) $x, 'y' => (int) $y]);
    }

    public function actionPart()
    {
        $x = $this->ajaxData['x'];
        $y = $this->ajaxData['y'];

        if (!Map::check($x, $y)) {
            throw new BadRequestHttpException("Error map position");
        }

        $mapData = Map::getPart($x, $y);
        $result = [];
        foreach ($mapData as $i => $mapp) {
            foreach ($mapp as $j => $map) {
                $arr = null;
                if ($map) {
                    $arr = $map->toArray();
                    if ($map->village) {
                        $arr['village'] = $map->village->toArray();
                        $myVillage = $map->village->user_id == $this->currentUser->id;
                        if ($myVillage) {
                            $arr['my'] = true;
                            $arr['url'] = Url::to(['village/view', 'id' => $map->village->id]);
                        } else {
                            $arr['enemy'] = true;
                            $arr['url'] = Url::to(['village/enemy', 'id' => $map->village->id]);
                        }
                    }
                }
                $result[$i][$j] = $arr;
            }
        }
        return $this->asJson($result);
    }
}
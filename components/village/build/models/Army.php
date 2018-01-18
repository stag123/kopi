<?php

namespace app\components\village\build\models;

use app\components\village\build\unit\models\Unit;
use app\models\Resources;

/**
 * @inheritdoc
 * @property array $units
 */
class Army extends BuildInfo
{
    public $maxLevel = 3;

    public function getBuild()
    {
        return Build::getArmy();
    }

    public function getPrice() {
        $price = new Resources();
        switch($this->level) {
            case 1:
                $price->iron = 400;
                $price->grain = 380;
                $price->stone = 330;
                $price->wood = 420;
                break;
            case 2:
                $price->iron = 700;
                $price->grain = 480;
                $price->stone = 530;
                $price->wood = 670;
                break;
            case 3:
                $price->iron = 1200;
                $price->grain = 1320;
                $price->stone = 980;
                $price->wood = 890;
                break;
        }
        return $price;
    }

    public function getBuildTime() {
        switch($this->level) {
            case 1:
                return getSpeed(60 * 13 + 23);
            case 2:
                return getSpeed(60 * 23 + 56);
            case 3:
                return getSpeed(60 * 31 + 6);
        }
    }

    public function getGrainCost()
    {
        switch($this->level) {
            case 1:
                return 3;
            case 2:
                return 5;
            case 3:
                return 9;
        }
    }

    public function getUnits()
    {
        switch($this->level) {
            case 1:
                return [Unit::getSword()];
            case 2:
                return [Unit::getSword(), Unit::getArcher()];
            case 3:
                return [Unit::getSword(), Unit::getArcher(), Unit::getCatapult()];
        }
    }

    public function attributes()
    {
        return array_merge(['units'], parent::attributes());
    }
}
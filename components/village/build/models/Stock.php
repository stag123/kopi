<?php

namespace app\components\village\build\models;

use app\models\Resources;

/**
 * @inheritdoc
 * @property int $size
 */
class Stock extends BuildInfo
{
    public $maxLevel = 2;
    public function getBuild()
    {
        return Build::getStock();
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
                $price->iron = 793;
                $price->grain = 482;
                $price->stone = 642;
                $price->wood = 510;
                break;
        }
        return $price;
    }

    public function getBuildTime() {
        switch($this->level) {
            case 1:
                return getSpeed(60 * 13 + 20);
            case 2:
                return getSpeed(60 * 21 + 9);
        }
    }

    public function getGrainCost()
    {
        switch($this->level) {
            case 1:
                return 3;
            case 2:
                return 5;
        }
    }

    public function getSize()
    {
        switch($this->level) {
            case 1:
                return 1200;
            case 2:
                return 2000;
        }
    }

    public function attributes()
    {
        return array_merge(['size'], parent::attributes());
    }
}
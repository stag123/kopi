<?php

namespace app\components\village\build\models;

use app\models\Resources;

/**
 * @inheritdoc
 * @property int $size
 */
class Granary extends BuildInfo
{
    public $maxLevel = 2;
    public function getBuild()
    {
        return Build::getGranary();
    }

    public function getPrice() {
        $price = new Resources();
        switch($this->level) {
            case 1:
                $price->iron = 310;
                $price->grain = 320;
                $price->stone = 330;
                $price->wood = 220;
                break;
            case 2:
                $price->iron = 450;
                $price->grain = 550;
                $price->stone = 690;
                $price->wood = 420;
                break;
        }
        return $price;
    }

    public function getBuildTime() {
        switch($this->level) {
            case 1:
                return getSpeed(60 * 13 + 20);
            case 2:
                return getSpeed(60 * 26 + 45);
        }
    }

    public function getGrainCost()
    {
        switch($this->level) {
            case 1:
                return 3;
            case 1:
                return 5;
        }
    }

    public function getSize()
    {
        switch($this->level) {
            case 1:
                return 1200;
            case 1:
                return 1600;
        }
    }


    public function attributes()
    {
        return array_merge(['size'], parent::attributes());
    }
}
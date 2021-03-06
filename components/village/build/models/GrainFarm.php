<?php

namespace app\components\village\build\models;

use app\models\Resources;

/**
 * @inheritdoc
 * @property Resources $changeResource
 */
class GrainFarm extends BuildInfo
{
    public $maxLevel = 3;
    public function getBuild()
    {
        return Build::getGrainFarm();
    }

    public function getPrice() {
        $price = new Resources();
        switch($this->level) {
            case 1:
                $price->grain = 200;
                $price->wood = 80;
                $price->stone = 80;
                $price->iron = 70;
                break;
            case 2:
                $price->grain = 320;
                $price->wood = 130;
                $price->stone = 140;
                $price->iron = 90;
                break;
            case 3:
                $price->grain = 640;
                $price->wood = 310;
                $price->stone = 270;
                $price->iron = 160;
                break;
        }
        return $price;
    }

    public function getBuildTime() {
        switch($this->level) {
            case 1:
                return getSpeed(60 * 2 + 20);
            case 2:
                return getSpeed(7 * 60 + 43);
            case 3:
                return getSpeed(23 * 60 + 28);
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
                return 7;
        }
    }

    public function getChangeResource() {
        $changeResource = new Resources();
        switch($this->level) {
            case 1:
                $changeResource->grain = 9;
                break;
            case 2:
                $changeResource->grain = 20;
                break;
            case 3:
                $changeResource->grain = 45;
                break;
        }
        return $changeResource;
    }

    public function attributes()
    {
        return array_merge(['changeResource'], parent::attributes());
    }
}
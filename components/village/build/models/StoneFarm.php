<?php

namespace app\components\village\build\models;

use app\models\Resources;
use phpDocumentor\Reflection\Types\Resource;

/**
 * @inheritdoc
 * @property Resources $changeResource
 */
class StoneFarm extends BuildInfo
{
    public function getBuild()
    {
        return Build::getWoodFarm();
    }

    public function getPrice() {
        $price = new Resources();
        switch($this->level) {
            case 1:
                $price->stone = 200;
                $price->grain = 80;
                $price->wood = 80;
                $price->iron = 70;
                break;
            case 2:
                $price->stone = 320;
                $price->grain = 130;
                $price->wood = 140;
                $price->iron = 90;
                break;
            case 3:
                $price->stone = 640;
                $price->grain = 310;
                $price->wood = 270;
                $price->iron = 160;
                break;
        }
        return $price;
    }

    public function getBuildTime() {
        switch($this->level) {
            case 1:
                return 60 * 2 + 20;
            case 2:
                return 7 * 60 + 43;
            case 3:
                return 23 * 60 + 28;
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
        $changeResource = new Resource();
        switch($this->level) {
            case 1:
                $changeResource->stone = 9;
                break;
            case 2:
                $changeResource->stone = 20;
                break;
            case 3:
                $changeResource->stone = 45;
                break;
        }
        return $changeResource;
    }

    public function attributes()
    {
        return array_merge(['changeResource'], parent::attributes());
    }
}
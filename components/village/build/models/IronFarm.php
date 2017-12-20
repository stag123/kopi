<?php

namespace app\components\village\build\models;

use app\models\Resources;
use phpDocumentor\Reflection\Types\Resource;

/**
 * @inheritdoc
 * @property Resources $changeResource
 */
class IronFarm extends BuildInfo
{
    public function getBuild()
    {
        return Build::getIronFarm();
    }

    public function getPrice() {
        $price = new Resources();
        switch($this->level) {
            case 1:
                $price->iron = 200;
                $price->grain = 80;
                $price->stone = 80;
                $price->wood = 70;
                break;
            case 2:
                $price->iron = 320;
                $price->grain = 130;
                $price->stone = 140;
                $price->wood = 90;
                break;
            case 3:
                $price->iron = 640;
                $price->grain = 310;
                $price->stone = 270;
                $price->wood = 160;
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
                $changeResource->iron = 9;
                break;
            case 2:
                $changeResource->iron = 20;
                break;
            case 3:
                $changeResource->iron = 45;
                break;
        }
        return $changeResource;
    }

    public function attributes()
    {
        return array_merge(['changeResource'], parent::attributes());
    }
}
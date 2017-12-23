<?php

namespace app\components\village\build\models;

use app\models\Resources;

/**
 * @inheritdoc
 * @property int $units
 */
class Army extends BuildInfo
{
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
        }
        return $price;
    }

    public function getBuildTime() {
        switch($this->level) {
            case 1:
                return 60 * 13 + 20;
        }
    }

    public function getGrainCost()
    {
        switch($this->level) {
            case 1:
                return 3;
        }
    }

    public function getUnits()
    {
        switch($this->level) {
            case 1:
                return 1;
        }
    }

    public function attributes()
    {
        return array_merge(['units'], parent::attributes());
    }
}
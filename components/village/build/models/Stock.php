<?php

namespace app\components\village\build\models;

use app\models\Resources;
use phpDocumentor\Reflection\Types\Resource;

/**
 * @inheritdoc
 * @property int $size
 */
class Stock extends BuildInfo
{
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

    public function getSize()
    {
        switch($this->level) {
            case 1:
                return 1200;
        }
    }

    public function attributes()
    {
        return array_merge(['size'], parent::attributes());
    }
}
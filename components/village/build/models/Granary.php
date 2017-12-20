<?php

namespace app\components\village\build\models;

use app\models\Resources;
use phpDocumentor\Reflection\Types\Resource;

/**
 * @inheritdoc
 * @property int $size
 */
class Granary extends BuildInfo
{
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
<?php

namespace app\components\village\build\models;

use app\components\BaseModel;
use app\models\Resources;

/**
 * @property $buildTime
 * @property Resources $price
 * @property $grainCost
 * @property Build $build
 */
abstract class BuildInfo extends BaseModel
{
    public $level;
    public $maxLevel = 1;

    abstract public function getBuild();

    abstract public function getPrice();

    abstract public function getGrainCost();

    abstract public function getBuildTime();

    /**
     * @param $level
     * @return null|static
     */
    public static function getByLevel($level) {
        if ($level <= 0) {
            return null;
        }
        $obj = new static();
        $obj->level = $level;
        if ($level > $obj->maxLevel) {
            return null;
        }
        return $obj;
    }

    public function toArray() {
        return $this->getAttributes();
    }

    public function attributes()
    {
        return array_merge(['buildTime', 'price', 'grainCost', 'build'], parent::attributes());
    }
}
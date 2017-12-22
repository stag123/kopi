<?php

namespace app\components\village\build\unit\models;

use app\components\BaseModel;
use app\models\Resources;

class Unit extends BaseModel
{
    const ID_SWORD = 1;
    const ID_CATAPULT = 2;

    public $name;
    public $id;
    public $code;
    public $speed;
    /**
     * @var Resources $price
     */
    public $price;
    public $bag;
    public $grainCost;
    public $buildTime;
    public $attack = 0;
    public $defence = 0;
    public $attackArcher = 0;
    public $defenceArcher = 0;
    public $attackHorse = 0;
    public $defenceHorse = 0;
    public $attackDestroy = 0;

    public static function getSword() {
        $model = new self();
        $model->id = self::ID_SWORD;
        $model->name = 'Мечник';
        $model->code = 'sword';
        $model->attack = 40;
        $model->defence = 30;
        $model->defenceArcher = 20;
        $model->defenceHorse = 30;
        $model->bag = 40;
        $model->speed = 5;
        $model->grainCost = 1;
        $model->buildTime = 10 * 60 + 24;
        $model->price = new Resources();
        $model->price->grain = 40;
        $model->price->iron = 200;
        $model->price->wood = 120;
        $model->price->stone = 50;
        return $model;
    }

    public static function getCatapult() {
        $model = new self();
        $model->id = self::ID_CATAPULT;
        $model->name = 'Катапульта';
        $model->code = 'catapult';
        $model->defence = 10;
        $model->defenceArcher = 10;
        $model->defenceHorse = 10;
        $model->speed = 3;
        $model->grainCost = 5;
        $model->buildTime = 24 * 60 + 43;
        $model->price = new Resources();
        $model->price->grain = 150;
        $model->price->iron = 500;
        $model->price->wood = 320;
        $model->price->stone = 280;
        return $model;
    }
}

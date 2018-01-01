<?php

namespace app\components\village\build\unit\models;

use app\components\BaseModel;
use app\models\Resources;

class Unit extends BaseModel
{
    const ID_SWORD = 1;
    const ID_CATAPULT = 2;

    const CODE_SWORD = 'sword';
    const CODE_CATAPULT = 'catapult';

    public $name;
    public $description;
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
    public $damage = 0;
    public $attackArcher = 0;
    public $defenceArcher = 0;
    public $attackHorse = 0;
    public $defenceHorse = 0;
    public $attackDestroy = 0;


    public static function GetTypes() {
        return [
            self::CODE_SWORD,
            self::CODE_CATAPULT
        ];
    }
    /**
     * @param $id
     * @return Unit|null
     */
    public static function GetByID($id) {
        switch($id) {
            case self::ID_SWORD: return self::getSword();
            case self::ID_CATAPULT: return self::getCatapult();
            default: return null;
        }
    }

    public static function GetByCode($type) {
        switch($type) {
            case self::CODE_SWORD: return self::getSword();
            case self::CODE_CATAPULT: return self::getCatapult();
            default: return null;
        }
    }

    public static function getSword() {
        $model = new self();
        $model->id = self::ID_SWORD;
        $model->name = 'Мечник';
        $model->description = 'Мечник хорош как в обороне так и внападении';
        $model->code = self::CODE_SWORD;
        $model->attack = 40;
        $model->defence = 30;
        $model->defenceArcher = 20;
        $model->defenceHorse = 30;
        $model->bag = 40;
        $model->speed = 5;
        $model->grainCost = 1;
        $model->buildTime = 5;//10 * 60 + 24;
        $model->price = new Resources();
        $model->price->grain = 40;
        $model->price->iron = 100;
        $model->price->wood = 120;
        $model->price->stone = 50;
        return $model;
    }

    public static function getCatapult() {
        $model = new self();
        $model->id = self::ID_CATAPULT;
        $model->name = 'Катапульта';
        $model->description = 'Катапульта хороша в разрушении вражеских зданий';
        $model->code = self::CODE_CATAPULT;
        $model->defence = 10;
        $model->damage = 4;
        $model->defenceArcher = 10;
        $model->defenceHorse = 10;
        $model->speed = 3;
        $model->grainCost = 5;
        $model->buildTime = 12;//24 * 60 + 43;
        $model->price = new Resources();
        $model->price->grain = 150;
        $model->price->iron = 400;
        $model->price->wood = 320;
        $model->price->stone = 280;
        return $model;
    }
}

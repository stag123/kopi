<?php

namespace app\components\village\build\models;

use app\components\BaseModel;
use app\models\VillageMap;

class Build extends BaseModel
{
    const ID_GRAIN_FARM = 1;
    const ID_WOOD_FARM = 2;
    const ID_STONE_FARM = 3;
    const ID_IRON_FARM = 4;
    const ID_ARMY = 5;
    const ID_STOCK = 6;
    const ID_GRANARY = 7;


    public $id;
    public $map_type;
    public $name;
    public $description;
    public $code;

    /**
     * @param $id
     * @return Build|null
     */
    public static function GetByID($id) {
        switch($id) {
            case self::ID_GRAIN_FARM: return self::getGrainFarm();
            case self::ID_WOOD_FARM: return self::getWoodFarm();
            case self::ID_STONE_FARM: return self::getStoneFarm();
            case self::ID_IRON_FARM: return self::getIronFarm();
            case self::ID_ARMY: return self::getArmy();
            case self::ID_STOCK: return self::getStock();
            case self::ID_GRANARY: return self::getGranary();
            default: return null;
        }
    }

    public static function getGrainFarm()
    {
        $model = new self();
        $model->id = self::ID_GRAIN_FARM;
        $model->map_type = VillageMap::TYPE_GRAIN;
        $model->name = 'Ферма';
        $model->code = 'grain_farm';
        $model->description = 'На ферме выращивают зерно';
        return $model;
    }

    public static function getWoodFarm()
    {
        $model = new self();
        $model->id = self::ID_WOOD_FARM;
        $model->map_type = VillageMap::TYPE_WOOD;
        $model->name = 'Лесопилка';
        $model->code = 'wood_farm';
        $model->description = 'На лесопилке добывают дерево';
        return $model;
    }

    public static function getStoneFarm()
    {
        $model = new self();
        $model->id = self::ID_STONE_FARM;
        $model->map_type = VillageMap::TYPE_STONE;
        $model->name = 'Каменоломня';
        $model->description = 'На каменоломне добывают камень';
        $model->code = 'stone_farm';
        return $model;
    }

    public static function getIronFarm()
    {
        $model = new self();
        $model->id = self::ID_IRON_FARM;
        $model->map_type = VillageMap::TYPE_IRON;
        $model->name = 'Рудная шахта';
        $model->description = 'На рудной шахте добывают железо';
        $model->code = 'iron_farm';
        return $model;
    }

    public static function getArmy()
    {
        $model = new self();
        $model->id = self::ID_ARMY;
        $model->map_type = VillageMap::TYPE_EARTH;
        $model->description = 'В казарме строят войска';
        $model->name = 'Казарма';
        $model->code = 'army';
        return $model;
    }

    public static function getStock()
    {
        $model = new self();
        $model->id = self::ID_STOCK;
        $model->map_type = VillageMap::TYPE_EARTH;
        $model->name = 'Склад';
        $model->description = 'На складе хранятся такие ресурсы как камень, железо и дерево.';
        $model->code = 'stock';
        return $model;
    }

    public static function getGranary()
    {
        $model = new self();
        $model->id = self::ID_GRANARY;
        $model->map_type = VillageMap::TYPE_EARTH;
        $model->name = 'Амбар';
        $model->description = 'В амбаре хранится зерно.';
        $model->code = 'granary';
        return $model;
    }
}

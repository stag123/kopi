<?php

namespace app\models\data;

use app\models\Resource;
use Yii;
use app\models\Build as BuildModel;

class Build extends BuildModel
{

    const ID_GRAIN_FARM = 1;
    const ID_WOOD_FARM = 2;
    const ID_STONE_FARM = 3;
    const ID_IRON_FARM = 4;
    const ID_ARMY = 5;
    const ID_STOCK = 6;
    const ID_GRANARY = 7;

    public static function getGrainFarm()
    {
        $model = new BuildModel();
        $model->id = self::ID_GRAIN_FARM;
        $model->map_type = VillageMap::TYPE_GRAIN;
        $model->name = 'Ферма';
        $model->code = 'grain_farm';
        $model->description = 'На ферме выращивают зерно';
        return $model;
    }

    public static function getWoodFarm()
    {
        $model = new BuildModel();
        $model->id = self::ID_WOOD_FARM;
        $model->map_type = VillageMap::TYPE_WOOD;
        $model->name = 'Лесопилка';
        $model->code = 'wood_farm';
        $model->description = 'На лесопилке добывают дерево';
        return $model;
    }

    public static function getStoneFarm()
    {
        $model = new BuildModel();
        $model->id = self::ID_STONE_FARM;
        $model->map_type = VillageMap::TYPE_STONE;
        $model->name = 'Каменоломня';
        $model->description = 'На каменоломне добывают камень';
        $model->code = 'stone_farm';
        return $model;
    }

    public static function getIronFarm()
    {
        $model = new BuildModel();
        $model->id = self::ID_IRON_FARM;
        $model->map_type = VillageMap::TYPE_IRON;
        $model->name = 'Рудная шахта';
        $model->description = 'На рудной шахте добывают железо';
        $model->code = 'iron_farm';
        return $model;
    }

    public static function getArmy()
    {
        $model = new BuildModel();
        $model->id = self::ID_ARMY;
        $model->map_type = VillageMap::TYPE_EARTH;
        $model->description = 'В казарме строят войска';
        $model->name = 'Казарма';
        $model->code = 'army';
        return $model;
    }

    public static function getStock()
    {
        $model = new BuildModel();
        $model->id = self::ID_STOCK;
        $model->map_type = VillageMap::TYPE_EARTH;
        $model->name = 'Склад';
        $model->description = 'На складе хранятся такие ресурсы как камень, железо и дерево.';
        $model->code = 'stock';
        return $model;
    }

    public static function getGranary()
    {
        $model = new BuildModel();
        $model->id = self::ID_GRANARY;
        $model->map_type = VillageMap::TYPE_EARTH;
        $model->name = 'Амбар';
        $model->description = 'В амбаре хранится зерно.';
        $model->code = 'granary';
        return $model;
    }
}
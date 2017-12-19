<?php

namespace app\components\village\build;

use app\models\Resource;
use app\components\village\build\models\Build;


class BuildData extends \yii\base\Model {

    public $resource_size = 0;
    public $level;
    public $build_time;
    public $price;
    public $changeResource;
    public $build;


    /**
     * @param $id
     * @return BuildData
     */
    public static function GetByTypeAndLevel($typeId, $level) {
        switch($typeId) {
            case Build::ID_GRAIN_FARM: return self::getGrainFarm($level);
            case Build::ID_WOOD_FARM: return self::getWoodFarm($level);
            case Build::ID_STONE_FARM: return self::getStoneFarm($level);
            case Build::ID_IRON_FARM: return self::getIronFarm($level);
            case Build::ID_ARMY: return self::getArmy($level);
            case Build::ID_STOCK: return self::getStock($level);
            case Build::ID_GRANARY: return self::getGranary($level);
            default: return null;
        }
    }

    public static function getGrainFarm($level = 1) {
        $priceResource = new Resource();
        $changeResource = new Resource();
        $model = new BuildData();
        $model->build_time = 200;
        $model->level = $level;
        $model->price = $priceResource;
        $model->changeResource = $changeResource;
        $model->build = Build::getGrainFarm();
        switch($level) {
            case 1:
                $priceResource->grain = 200;
                $priceResource->wood = 80;
                $priceResource->stone = 80;
                $priceResource->iron = 70;

                $changeResource->grain = 9;

                $model->build_time = 60 * 2 + 20;
                break;
            case 2:
                $priceResource->grain = 320;
                $priceResource->wood = 130;
                $priceResource->stone = 140;
                $priceResource->iron = 90;

                $changeResource->grain = 20;

                $model->build_time = 7 * 60 + 43;
                break;
            case 3:
                $priceResource->grain = 640;
                $priceResource->wood = 310;
                $priceResource->stone = 270;
                $priceResource->iron = 160;

                $changeResource->grain = 45;

                $model->build_time = 23 * 60 + 28;
                break;
            default:
                return null;
        }

        return $model;
    }

    public static function getWoodFarm($level = 1) {
        $priceResource = new Resource();
        $changeResource = new Resource();
        $model = new BuildData();
        $model->build_time = 200;
        $model->level = $level;
        $model->price = $priceResource;
        $model->changeResource = $changeResource;
        $model->build = Build::getWoodFarm();

        switch($level) {
            case 1:
                $priceResource->grain = 200;
                $priceResource->wood = 80;
                $priceResource->stone = 80;
                $priceResource->iron = 70;

                $changeResource->grain = -1;
                $changeResource->wood = 9;

                $model->build_time = 60 * 2 + 20;
                break;
            case 2:
                $priceResource->grain = 320;
                $priceResource->wood = 130;
                $priceResource->stone = 140;
                $priceResource->iron = 90;

                $changeResource->grain = -4;
                $changeResource->wood = 20;

                $model->build_time = 7 * 60 + 43;
                break;
            case 3:
                $priceResource->grain = 640;
                $priceResource->wood = 310;
                $priceResource->stone = 270;
                $priceResource->iron = 160;

                $changeResource->grain = -6;
                $changeResource->wood = 45;

                $model->build_time = 23 * 60 + 28;
                break;
            default:
                return null;
        }

        return $model;
    }

    public static function getIronFarm($level = 1) {
        $priceResource = new Resource();
        $changeResource = new Resource();
        $model = new BuildData();
        $model->build_time = 200;
        $model->level = $level;
        $model->price = $priceResource;
        $model->changeResource = $changeResource;
        $model->build = Build::getIronFarm();

        switch($level) {
            case 1:
                $priceResource->grain = 200;
                $priceResource->wood = 80;
                $priceResource->stone = 80;
                $priceResource->iron = 70;

                $changeResource->grain = -1;
                $changeResource->iron = 9;

                $model->build_time = 60 * 2 + 20;
                break;
            case 2:
                $priceResource->grain = 320;
                $priceResource->wood = 130;
                $priceResource->stone = 140;
                $priceResource->iron = 90;

                $changeResource->grain = -4;
                $changeResource->iron = 20;

                $model->build_time = 7 * 60 + 43;
                break;
            case 3:
                $priceResource->grain = 640;
                $priceResource->wood = 310;
                $priceResource->stone = 270;
                $priceResource->iron = 160;

                $changeResource->grain = -6;
                $changeResource->iron = 45;

                $model->build_time = 23 * 60 + 28;
                break;
            default:
                return null;
        }

        return $model;
    }

    public static function getStoneFarm($level = 1) {
        $priceResource = new Resource();
        $changeResource = new Resource();
        $model = new BuildData();
        $model->build_time = 200;
        $model->level = $level;
        $model->price = $priceResource;
        $model->changeResource = $changeResource;
        $model->build = Build::getStoneFarm();

        switch($level) {
            case 1:
                $priceResource->grain = 200;
                $priceResource->wood = 80;
                $priceResource->stone = 80;
                $priceResource->iron = 70;

                $changeResource->grain = -1;
                $changeResource->stone = 9;

                $model->build_time = 60 * 2 + 20;
                break;
            case 2:
                $priceResource->grain = 320;
                $priceResource->wood = 130;
                $priceResource->stone = 140;
                $priceResource->iron = 90;

                $changeResource->grain = -4;
                $changeResource->stone = 20;

                $model->build_time = 7 * 60 + 43;
                break;
            case 3:
                $priceResource->grain = 640;
                $priceResource->wood = 310;
                $priceResource->stone = 270;
                $priceResource->iron = 160;

                $changeResource->grain = -6;
                $changeResource->stone = 45;

                $model->build_time = 23 * 60 + 28;
                break;
            default:
                return null;
        }

        return $model;
    }

    public static function getArmy($level = 1) {
        $priceResource = new Resource();
        $changeResource = new Resource();
        $model = new BuildData();
        $model->build_time = 200;
        $model->level = $level;
        $model->price = $priceResource;
        $model->changeResource = $changeResource;
        $model->build = Build::getArmy();

        switch($level) {
            case 1:
                $priceResource->grain = 240;
                $priceResource->wood = 130;
                $priceResource->stone = 180;
                $priceResource->iron = 270;

                $changeResource->grain = -5;

                $model->build_time = 60 * 4 + 34;
                break;
            default:
                return null;
        }

        return $model;
    }

    public static function getStock($level = 1) {
        $priceResource = new Resource();
        $changeResource = new Resource();
        $model = new BuildData();
        $model->build_time = 200;
        $model->level = $level;
        $model->price = $priceResource;
        $model->changeResource = $changeResource;
        $model->build = Build::getStock();

        switch($level) {
            case 1:
                $priceResource->grain = 150;
                $priceResource->wood = 150;
                $priceResource->stone = 130;
                $priceResource->iron = 240;

                $changeResource->grain = -4;

                $model->build_time = 60 * 7 + 8;
                $model->resource_size = 2000;
                break;
            default:
                return null;
        }

        return $model;
    }

    public static function getGranary($level = 1) {
        $priceResource = new Resource();
        $changeResource = new Resource();
        $model = new BuildData();
        $model->build_time = 200;
        $model->level = $level;
        $model->price = $priceResource;
        $model->changeResource = $changeResource;
        $model->build = Build::getGranary();

        switch($level) {
            case 1:
                $priceResource->grain = 350;
                $priceResource->wood = 300;
                $priceResource->stone = 130;
                $priceResource->iron = 245;

                $changeResource->grain = -4;

                $model->build_time = 60 * 6 + 56;
                $model->resource_size = 2000;
                break;
            default:
                return null;
        }

        return $model;
    }
}
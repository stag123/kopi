<?php
namespace app\types;

use yii2mod\enum\helpers\BaseEnum;

class ResourceType extends BaseEnum {
    const IRON = 1;
    const STONE = 2;
    const WOOD = 3;
    const GRAIN = 4;

    public static $list = [
     self::IRON => 'iron',
     self::STONE => 'stone',
     self::WOOD => 'wood',
     self::GRAIN => 'grain',
    ];
}
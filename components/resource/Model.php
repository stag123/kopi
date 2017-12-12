<?php

namespace app\components\resource;

class Model {

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

    public $grain = 0;
    public $wood = 0;
    public $stone = 0;
    public $iron = 0;
}
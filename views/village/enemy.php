<?php

/**
 * @var app\components\BaseView $this
 * @var app\models\Village $village
 */



use app\assets\EnemyAsset;

EnemyAsset::register($this);
?>

<div class="enemy">


    <div class="title">Деревня игрока <?= $village->user->username;?></div>
    <div class="description">
        Деревня с населением: <?= $village->getPopulation();?><br/>
        Координаты: (<?= $village->map->x;?>, <?=$village->map->y;?>)
    </div>
    <a class="button attack">Напасть</a>
</div>

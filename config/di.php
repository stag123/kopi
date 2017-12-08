<?php

use yii\di\ServiceLocator;
use app\components\Resource;

$locator = Yii::$app;

$locator->set('resource', function() {
    return new Resource();
});

$locator = new ServiceLocator();

$locator->set('resource', function() {
    return new Resource();
});

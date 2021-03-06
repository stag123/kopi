<?php

Yii::$app->set('commandVillageCreate', function() {
    return new app\components\village\commands\Create();
});


global $user;

Yii::$app->set('currentUser', function() {
    global $user;
    if (isset($user)) {
        return $user;
    }
    $user = app\models\User::findOne(Yii::$app->user->id);
    return $user;
});

Yii::$app->set('commandVillageResourceCalculate', function() {
    return new app\components\village\resource\commands\Calculate();
});

Yii::$app->set('buildFactory', function() {
    return new app\components\village\build\BuildFactory();
});

Yii::$app->set('commandTaskCreate', function() {
    return new app\components\task\commands\Create();
});

Yii::$app->set('commandTaskCheck', function() {
    return new app\components\task\commands\Check();
});

Yii::$app->set('logger', function() {
    return new app\components\logger\Logger();
});

define('SPEED', (YII_ENV_DEV ? 0.0001: 1));
function getSpeed($time) {
    return max(5, round(SPEED * $time));
}
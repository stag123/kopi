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

Yii::$app->set('villageResourceQuery', function() {
    return new app\components\village\resource\Query();
});

Yii::$app->set('buildFactory', function() {
    return new app\components\village\build\BuildFactory();
});
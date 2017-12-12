<?php
Yii::$app->set('commandResourceCreate', function() {
    return new app\components\resource\commands\Create();
});

Yii::$app->set('commandVillageCreate', function() {
    return new app\components\village\commands\Create();
});

Yii::$app->set('resourceQuery', function() {
    return new app\components\resource\Query();
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
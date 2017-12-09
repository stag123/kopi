<?php
Yii::$app->set('commandResourceCreate', function() {
    return new app\components\resource\commands\Create();
});

Yii::$app->set('commandVillageCreate', function() {
    return new app\components\village\commands\Create();
});
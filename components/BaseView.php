<?php

namespace app\components;

class BaseView extends \yii\web\View implements InjectionAwareInterface {
    public function __get($name) {
        if (\Yii::$app->has($name)) {
            return \Yii::$app->get($name);
        }
        return parent::__get($name);
    }
}
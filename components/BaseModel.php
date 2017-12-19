<?php

namespace app\components;

class BaseModel extends \yii\base\Model implements InjectionAwareInterface {
    public function __get($name) {
        if (\Yii::$app->has($name)) {
            return \Yii::$app->get($name);
        }
        return parent::__get($name);
    }

    public static function fetchById($id) {

    }
}
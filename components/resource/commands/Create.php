<?php

namespace app\components\resource\commands;
use app\models\ResourceValue;
use app\models\ResourceGroup;
use app\components\resource\Model;
use yii\web\BadRequestHttpException;


class Create extends \app\components\BaseComponent {

    public function execute(Model $model) {
        $group = new ResourceGroup();
        $group_id = $group->save();
        foreach(Model::$list as $id => $key) {
            $value = new ResourceValue();
            $value->value = $model->$key;
            $value->resource_id = $id;
            $value->group_id = $group_id;
            if (!$value->save()) {
                throw new BadRequestHttpException("Error create resource value");
            };
        }
        return $group_id;
    }
}
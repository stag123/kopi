<?php

namespace app\components\resource\commands;
use app\models\Resource as ResourceModel;
use app\models\ResourceValue;
use app\models\ResourceGroup;
use app\types\ResourceType;


class Create extends \app\components\BaseComponent {

    public function execute(array $resources) {
        $group = new ResourceGroup();
        $group_id = $group->save();
        foreach($resources as $id => $value) {
            $value = new ResourceValue();
            $value->value = $value;
            $value->id = $id;
            $value->resource_group_id = $group_id;
            $value->save();
        }
        return $group_id;
    }
}
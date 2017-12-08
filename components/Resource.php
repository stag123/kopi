<?php

namespace app\components;
use app\models\Resource as ResourceModel;
use app\models\ResourceValue;
use app\models\ResourceGroup;
use app\types\ResourceType;


class Resource extends \yii\base\Component {

    const IRON = 'iron';
    const STONE = 'stone';
    const WOOD = 'wood';
    const GRAIN = 'grain';

    public function create(array $resources) {
        $group = new ResourceGroup();
        $group_id = $group->save();
        foreach($resources as $id => $value) {
            $value = new ResourceValue();
            $value->value = $value;
            $value->id = $id;
            $value->resource_group_id = $group_id;
            $value->save();
        }
    }
}
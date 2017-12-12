<?php

namespace app\components\resource;
use app\models\Resource as ResourceModel;
use app\models\ResourceValue;
use app\models\ResourceGroup;


class Query extends \app\components\BaseComponent {

    /**
     * @param ResourceGroup $group
     * @param ResourceType $type
     * @return Model
     */
    public function fetch(ResourceGroup $group) {
        $resources = $group->getResourceValues()->all();

        if (!$resources) {
            return new Model();
        }
        $result = [];
        foreach ($resources as $resource) {
            $result[$resource->id] = $resource->value;
        }

        $model = new Model();

        $model->grain = $result[Model::GRAIN];
        $model->iron = $result[Model::IRON];
        $model->stone = $result[Model::STONE];
        $model->wood = $result[Model::WOOD];

        return $model;
    }
}
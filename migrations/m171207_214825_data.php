<?php

use \app\components\BaseMigration;

use app\models\Resource;
use app\models\Map;
use app\components\resource\Model as ResourceModel;

/**
 * Class m171207_214825_data
 */
class m171207_214825_data extends BaseMigration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $resource = new Resource();
        $resource->id = ResourceModel::IRON;
        $resource->name = 'Железо';
        $resource->code = 'iron';
        $resource->save();

        $resource = new Resource();
        $resource->id = ResourceModel::STONE;
        $resource->name = 'Камень';
        $resource->code = 'stone';
        $resource->save();

        $resource = new Resource();
        $resource->id = ResourceModel::WOOD;
        $resource->name = 'Дерево';
        $resource->code = 'wood';
        $resource->save();

        $resource = new Resource();
        $resource->id = ResourceModel::GRAIN;
        $resource->name = 'Зерно';
        $resource->code = 'grain';
        $resource->save();

        Map::generate();
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        Resource::deleteAll();
        Map::deleteAll();
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171207_214825_data cannot be reverted.\n";

        return false;
    }
    */
}

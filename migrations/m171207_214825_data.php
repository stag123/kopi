<?php

use \app\components\BaseMigration;

use app\models\Resource;
use app\models\Map;
use app\types\ResourceType;

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
        $resource->id = ResourceType::IRON;
        $resource->name = 'Железо';
        $resource->code = 'iron';
        $resource->save();

        $resource = new Resource();
        $resource->id = ResourceType::STONE;
        $resource->name = 'Камень';
        $resource->code = 'stone';
        $resource->save();

        $resource = new Resource();
        $resource->id = ResourceType::WOOD;
        $resource->name = 'Дерево';
        $resource->code = 'wood';
        $resource->save();

        $resource = new Resource();
        $resource->id = ResourceType::GRAIN;
        $resource->name = 'Зерно';
        $resource->code = 'grain';
        $resource->save();

        Map::generate();

        $this->commandResourceCreate->execute([
            ResourceType::IRON => 100,
            ResourceType::WOOD => 100,
            ResourceType::GRAIN => 100,
            ResourceType::STONE => 100,
        ]);

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

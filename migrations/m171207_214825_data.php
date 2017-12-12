<?php

use \app\components\BaseMigration;

use app\models\Resource;
use app\models\Map;

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

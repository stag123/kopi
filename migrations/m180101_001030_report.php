<?php

use yii\db\Migration;

/**
 * Class m180101_001030_report
 */
class m180101_001030_report extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%report}}', [
            'id' => $this->primaryKey(),
            'type' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'village_id' => $this->integer()->notNull(),
            'title' => $this->string()->notNull(),
            'details'     => $this->text(),
            'created_at' => $this->datetime(),
            'updated_at' => $this->datetime(),
        ], $tableOptions);

        $this->addForeignKey(
            'FK_report_village', '{{%report}}', 'village_id', '{{%village}}', 'id', 'CASCADE', 'CASCADE'
        );

        $this->addForeignKey(
            'FK_report_user', '{{%report}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('{{%report}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180101_001030_report cannot be reverted.\n";

        return false;
    }
    */
}

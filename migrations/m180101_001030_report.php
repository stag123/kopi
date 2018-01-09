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
            'status' => $this->integer()->defaultValue(0),
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

        $this->createTable('{{%message}}', [
            'id' => $this->primaryKey(),
            'status' => $this->integer()->defaultValue(0),
            'user_from_id' => $this->integer()->notNull(),
            'user_to_id' => $this->integer()->notNull(),
            'title' => $this->string()->defaultValue("Без темы"),
            'text'     => $this->text(),
            'created_at' => $this->datetime(),
            'updated_at' => $this->datetime(),
        ], $tableOptions);

        $this->addForeignKey(
            'FK_report_user_from', '{{%message}}', 'user_from_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE'
        );

        $this->addForeignKey(
            'FK_report_user_to', '{{%message}}', 'user_to_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('{{%report}}');
        $this->dropTable('{{%message}}');
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

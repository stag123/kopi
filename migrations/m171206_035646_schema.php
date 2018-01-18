<?php

use \app\components\BaseMigration;

/**
 * Class m171206_035646_schema
 */
class m171206_035646_schema extends BaseMigration
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

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'email' => $this->string(),
            'username' => $this->string()->notNull(),
            'name'     => $this->string(),
            'last_name'  => $this->string(),
            'identity'   => $this->string(),
            'auth_key' => $this->string(32),
            'status' => $this->smallInteger()->defaultValue(10),
            'created_at' => $this->datetime(),
            'updated_at' => $this->datetime(),
        ], $tableOptions);

        /** Ресурсы */
        $this->createTable('{{%resources}}', [
            'id' => $this->primaryKey(),
            'wood' => $this->double(3)->defaultValue(0),
            'grain' => $this->double(3)->defaultValue(0),
            'iron' => $this->double(3)->defaultValue(0),
            'stone' => $this->double(3)->defaultValue(0),
        ], $tableOptions);

        /** Карта и деревня */
        $this->createTable('{{%map}}', [
            'id' => $this->primaryKey(),
            'x' => $this->integer()->notNull(),
            'y' => $this->integer()->notNull(),
            'type' => $this->integer()->notNull(),
            'status' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('UQ_map_xy', '{{%map}}', ['x', 'y'], true);

        $this->createTable('{{%village}}', [
            'id'                  => $this->primaryKey(),
            'map_id'              => $this->integer()->notNull(),
            'user_id'             => $this->integer()->notNull(),
            'name'                => $this->string(),
            'village_resources_id' => $this->integer()->notNull(),
            'created_at'          => $this->datetime(),
            'resources_updated_at' => $this->bigInteger(),
        ], $tableOptions);

        $this->addForeignKey(
            'FK_village_user', '{{%village}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
            'FK_village_map', '{{%village}}', 'map_id', '{{%map}}', 'id', 'CASCADE', 'CASCADE'
        );

        $this->createIndex('UQ_village_map', '{{%village}}', 'map_id', true);

        $this->addForeignKey(
            'FK_village_resources', '{{%village}}', 'village_resources_id', '{{%resources}}', 'id', 'CASCADE', 'CASCADE'
        );

        $this->createIndex('UQ_village_resources', '{{%village}}', 'village_resources_id', true);

        $this->createTable('{{%village_map}}', [
            'id' => $this->primaryKey(),
            'x' => $this->integer()->notNull(),
            'y' => $this->integer()->notNull(),
            'level'    => $this->integer(),
            'build_id' => $this->integer(),
            'village_id' => $this->integer()->notNull(),
            'type' => $this->integer()->notNull(),
            'status' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('UQ_village_xy', '{{%village_map}}', ['x', 'y', 'village_id'], true);

        $this->addForeignKey(
            'FK_village_map_village', '{{%village_map}}', 'village_id', '{{%village}}', 'id', 'CASCADE', 'CASCADE'
        );

        $this->createTable('{{%units}}', [
            'id'          => $this->primaryKey(),
            'village_id'  => $this->integer()->notNull(),
            'map_id'      => $this->integer(),
            'sword'       => $this->integer()->defaultValue(0),
            'archer'       => $this->integer()->defaultValue(0),
            'catapult'       => $this->integer()->defaultValue(0)
        ], $tableOptions);

        $this->addForeignKey(
            'FK_unit_group_village', '{{%units}}', 'village_id', '{{%village}}', 'id', 'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
            'FK_unit_group_map', '{{%units}}', 'map_id', '{{%map}}', 'id', 'NO ACTION', 'NO ACTION'
        );

        /** Очередь заданий */
        $this->createTable('{{%task}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->datetime(),
            'updated_at' => $this->datetime(),
            'duration' => $this->integer()->notNull(),
            'village_from_id' => $this->integer()->notNull(),
            'village_to_id'   =>  $this->integer()->notNull(),
            'worker' => $this->integer(),
            'type' => $this->integer(),
            'status' => $this->integer(),
        ], $tableOptions);

        $this->addForeignKey(
            'FK_task_village_from', '{{%task}}', 'village_from_id', '{{%village}}', 'id', 'CASCADE', 'CASCADE'
        );

        $this->addForeignKey(
            'FK_task_village_to', '{{%task}}', 'village_to_id', '{{%village}}', 'id', 'CASCADE', 'CASCADE'
        );

        $this->createTable('{{%task_attack}}', [
            'id' => $this->primaryKey(),
            'units_id'     => $this->integer()->notNull(),
            'resources_id'    =>  $this->integer()->notNull(),
            'task_id'  => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('UQ_task_attack_task', '{{%task_attack}}', 'task_id', true);

        $this->addForeignKey(
            'FK_task_attack_resources', '{{%task_attack}}', 'resources_id', '{{%resources}}', 'id', 'CASCADE', 'CASCADE'
        );

        $this->addForeignKey(
            'FK_task_attack_task', '{{%task_attack}}', 'task_id', '{{%task}}', 'id', 'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
            'FK_task_attack_units', '{{%task_attack}}', 'units_id', '{{%units}}', 'id', 'CASCADE', 'CASCADE'
        );

        $this->createTable('{{%task_build}}', [
            'id'                  => $this->primaryKey(),
            'village_map_id'      =>  $this->integer()->notNull(),
            'build_id'            =>  $this->integer()->notNull(),
            'level'               =>  $this->integer()->defaultValue(0),
            'task_id'             => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('UQ_task_build_task', '{{%task_build}}', 'task_id', true);

        $this->addForeignKey(
            'FK_task_build_village_map', '{{%task_build}}', 'village_map_id', '{{%village_map}}', 'id', 'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
            'FK_task_build_task', '{{%task_build}}', 'task_id', '{{%task}}', 'id', 'CASCADE', 'CASCADE'
        );

        $this->createTable('{{%task_unit}}', [
            'id'                  => $this->primaryKey(),
            'count'               =>  $this->integer()->notNull(),
            'unit_id'             => $this->integer()->notNull(),
            'task_id'             => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addForeignKey(
            'FK_task_unit_task', '{{%task_unit}}', 'task_id', '{{%task}}', 'id', 'CASCADE', 'CASCADE'
        );

        $this->createIndex('UQ_task_unit_task', '{{%task_unit}}', 'task_id', true);

        $this->createTable('{{%task_trade}}', [
            'id'                   => $this->primaryKey(),
            'resources_id'    =>  $this->integer()->notNull(),
            'task_id'             => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addForeignKey(
            'FK_task_trade_task', '{{%task_trade}}', 'task_id', '{{%task}}', 'id', 'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
            'FK_task_trade_resources', '{{%task_trade}}', 'resources_id', '{{%resources}}', 'id', 'CASCADE', 'CASCADE'
        );

        $this->createIndex('UQ_task_trade_task', '{{%task_trade}}', 'task_id', true);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('{{%task_trade}}');
        $this->dropTable('{{%task_unit}}');
        $this->dropTable('{{%task_build}}');
        $this->dropTable('{{%task_attack}}');
        $this->dropTable('{{%task}}');

        $this->dropTable('{{%units}}');

        $this->dropTable('{{%village_map}}');
        $this->dropTable('{{%village}}');
        $this->dropTable('{{%map}}');

        $this->dropTable('{{%resources}}');

        $this->dropTable('{{%user}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171206_035646_schema cannot be reverted.\n";

        return false;
    }
    */
}

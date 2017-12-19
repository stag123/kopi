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
        $this->createTable('{{%resource}}', [
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
            'village_resource_id' => $this->integer()->notNull(),
            'created_at'          => $this->datetime(),
            'resource_updated_at' => $this->bigInteger(),
        ], $tableOptions);

        $this->addForeignKey(
            'FK_village_user', '{{%village}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
            'FK_village_map', '{{%village}}', 'map_id', '{{%map}}', 'id', 'CASCADE', 'CASCADE'
        );

        $this->createIndex('UQ_village_map', '{{%village}}', 'map_id', true);

        $this->addForeignKey(
            'FK_village_resource', '{{%village}}', 'village_resource_id', '{{%resource}}', 'id', 'CASCADE', 'CASCADE'
        );

        $this->createIndex('UQ_village_resource', '{{%village}}', 'village_resource_id', true);

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

        /** Войска */
        $this->createTable('{{%unit}}', [
            'id'                => $this->primaryKey(),
            'name'              => $this->string(),
            'code'              => $this->string(),
            'speed'             => $this->integer()->notNull(),
            'price_resource_id' => $this->integer()->notNull(),
            'resource_capacity' => $this->integer()->notNull(),
            'attack'            => $this->integer()->notNull(),
            'defence'           => $this->integer()->notNull(),
            'attack_archer'     => $this->integer()->notNull(),
            'defence_archer'    => $this->integer()->notNull(),
            'attack_horse'      => $this->integer()->notNull(),
            'defence_horse'     => $this->integer()->notNull(),
            'change_resource_id'  => $this->integer()->notNull(),
            'build_time'        => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('UQ_unit_price', '{{%unit}}', 'price_resource_id', true);

        $this->addForeignKey(
            'FK_unit_price_resource', '{{%unit}}', 'price_resource_id', '{{%resource}}', 'id', 'CASCADE', 'CASCADE'
        );

        $this->addForeignKey(
            'FK_unit_change_resource', '{{%unit}}', 'change_resource_id', '{{%resource}}', 'id', 'CASCADE', 'CASCADE'
        );

        $this->createTable('{{%unit_group}}', [
            'id'          => $this->primaryKey(),
            'village_id'  => $this->integer()->notNull(),
            'map_id'      => $this->integer(),
        ], $tableOptions);

        $this->addForeignKey(
            'FK_unit_group_village', '{{%unit_group}}', 'village_id', '{{%village}}', 'id', 'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
            'FK_unit_group_map', '{{%unit_group}}', 'map_id', '{{%map}}', 'id', 'NO ACTION', 'NO ACTION'
        );

        $this->createTable('{{%unit_value}}', [
            'id'                => $this->primaryKey(),
            'unit_id'           => $this->integer()->notNull(),
            'unit_group_id'     => $this->integer()->notNull(),
            'value'             => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('UQ_unit_value_unit_group', '{{%unit_value}}', ['unit_id', 'unit_group_id'], true);

        $this->addForeignKey(
            'FK_unit_value_group', '{{%unit_value}}', 'unit_group_id', '{{%unit_group}}', 'id', 'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
            'FK_unit_value_unit', '{{%unit_value}}', 'unit_id', '{{%unit}}', 'id', 'CASCADE', 'CASCADE'
        );

        /** Очередь заданий */
        $this->createTable('{{%task}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->datetime(),
            'updated_at' => $this->datetime(),
            'duration' => $this->integer()->notNull(),
            'status' => $this->integer(),
        ], $tableOptions);

        $this->createTable('{{%task_attack}}', [
            'id' => $this->primaryKey(),
            'village_from_id' => $this->integer()->notNull(),
            'village_to_id'   =>  $this->integer()->notNull(),
            'unit_group_id'     => $this->integer()->notNull(),
            'task_id'  => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('UQ_task_attack_task', '{{%task_attack}}', 'task_id', true);

        $this->addForeignKey(
            'FK_task_attack_village_from', '{{%task_attack}}', 'village_from_id', '{{%village}}', 'id', 'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
            'FK_task_attack_village_to', '{{%task_attack}}', 'village_to_id', '{{%village}}', 'id', 'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
            'FK_task_attack_task', '{{%task_attack}}', 'task_id', '{{%task}}', 'id', 'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
            'FK_task_attack_unit_group', '{{%task_attack}}', 'unit_group_id', '{{%unit_group}}', 'id', 'CASCADE', 'CASCADE'
        );

        $this->createTable('{{%task_build}}', [
            'id'                  => $this->primaryKey(),
            'village_id'          => $this->integer()->notNull(),
            'village_map_id'      =>  $this->integer()->notNull(),
            'build_id'            =>  $this->integer()->notNull(),
            'level'               =>  $this->integer()->defaultValue(0),
            'task_id'             => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('UQ_task_build_task', '{{%task_build}}', 'task_id', true);

        $this->addForeignKey(
            'FK_task_village_map', '{{%task_build}}', 'village_id', '{{%village}}', 'id', 'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
            'FK_task_build_village_map', '{{%task_build}}', 'village_map_id', '{{%village_map}}', 'id', 'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
            'FK_task_build_task', '{{%task_build}}', 'task_id', '{{%task}}', 'id', 'CASCADE', 'CASCADE'
        );

        $this->createTable('{{%task_unit}}', [
            'id'                  => $this->primaryKey(),
            'village_id'          => $this->integer()->notNull(),
            'count'               =>  $this->integer()->notNull(),
            'unit_id'             => $this->integer()->notNull(),
            'task_id'             => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addForeignKey(
            'FK_task_unit_village', '{{%task_unit}}', 'village_id', '{{%village}}', 'id', 'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
            'FK_task_unit_task', '{{%task_unit}}', 'task_id', '{{%task}}', 'id', 'CASCADE', 'CASCADE'
        );

        $this->createIndex('UQ_task_unit_task', '{{%task_unit}}', 'task_id', true);

        $this->createTable('{{%task_trade}}', [
            'id'                   => $this->primaryKey(),
            'village_from_id'      => $this->integer()->notNull(),
            'village_to_id'        =>  $this->integer()->notNull(),
            'resource_id'    =>  $this->integer()->notNull(),
            'task_id'             => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addForeignKey(
            'FK_task_trade_village_from', '{{%task_trade}}', 'village_from_id', '{{%village}}', 'id', 'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
            'FK_task_trade_village_to', '{{%task_trade}}', 'village_to_id', '{{%village}}', 'id', 'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
            'FK_task_trade_task', '{{%task_trade}}', 'task_id', '{{%task}}', 'id', 'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
            'FK_task_trade_resource', '{{%task_trade}}', 'resource_id', '{{%resource}}', 'id', 'CASCADE', 'CASCADE'
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

        $this->dropTable('{{%unit_value}}');
        $this->dropTable('{{%unit_group}}');
        $this->dropTable('{{%unit}}');

        $this->dropTable('{{%village_map}}');
        $this->dropTable('{{%village}}');
        $this->dropTable('{{%map}}');

        $this->dropTable('{{%resource}}');

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

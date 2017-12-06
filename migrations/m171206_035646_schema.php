<?php

use yii\db\Migration;

/**
 * Class m171206_035646_schema
 */
class m171206_035646_schema extends Migration
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
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string(),
            'status' => $this->smallInteger()->defaultValue(10),
            'created_at' => $this->datetime()->notNull(),
            'updated_at' => $this->datetime()->notNull(),
        ], $tableOptions);

        /** Ресурсы */
        $this->createTable('{{%resource}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'code' => $this->string()
        ], $tableOptions);

        $this->createTable('{{%resource_group}}', [
            'id'          => $this->primaryKey(),
            'status'      => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%resource_value}}', [
            'id'                => $this->primaryKey(),
            'resource_id'       => $this->integer()->notNull(),
            'resource_group_id' => $this->integer()->notNull(),
            'value'             => $this->integer()->notNull(),
        ], $tableOptions);

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
        ], $tableOptions);

        $this->addForeignKey(
            'FK_unit_resource_group', '{{%unit}}', 'price_resource_id', '{{%resource_group}}', 'id', 'CASCADE', 'CASCADE'
        );

        $this->createTable('{{%unit_group}}', [
            'id'          => $this->primaryKey(),
            'status'      => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%unit_value}}', [
            'id'                => $this->primaryKey(),
            'unit_id'           => $this->integer()->notNull(),
            'unit_group_id'     => $this->integer()->notNull(),
            'value'             => $this->integer()->notNull(),
        ], $tableOptions);


        /** Карта и деревня */
        $this->createTable('{{%map}}', [
            'id' => $this->primaryKey(),
            'x' => $this->integer()->notNull(),
            'y' => $this->integer()->notNull(),
            'type' => $this->integer()->notNull()
        ], $tableOptions);

        $this->createTable('{{%village}}', [
            'id'                  => $this->primaryKey(),
            'map_id'              => $this->integer()->notNull(),
            'user_id'             => $this->integer()->notNull(),
            'name'                => $this->string(),
            'village_resource_id' => $this->integer()->notNull(),
            'village_unit_id'     => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addForeignKey(
            'FK_village_user', '{{%village}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
            'FK_village_map', '{{%village}}', 'map_id', '{{%map}}', 'id', 'CASCADE', 'CASCADE'
        );

        $this->addForeignKey(
            'FK_village_resource_group', '{{%village}}', 'village_resource_id', '{{%resource_group}}', 'id', 'CASCADE', 'CASCADE'
        );

        $this->addForeignKey(
            'FK_village_unit_group', '{{%village}}', 'village_unit_id', '{{%unit_group}}', 'id', 'CASCADE', 'CASCADE'
        );
        /** Строения */
        $this->createTable('{{%build}}', [
            'id'                => $this->primaryKey(),
            'name'              => $this->string(),
            'code'              => $this->string()
        ], $tableOptions);

        $this->createTable('{{%build_level}}', [
            'id'                => $this->primaryKey(),
            'level'             => $this->integer()->notNull(),
            'build_id'          => $this->integer()->notNull(),
            'price_resource_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%build_village}}', [
            'id'                => $this->primaryKey(),
            'level'             => $this->integer()->notNull(),
            'build_id'          => $this->integer()->notNull(),
            'village_id'        => $this->integer()->notNull(),
            'build_level_id'    => $this->integer()->notNull(),
            'x'                 => $this->integer()->notNull(),
            'y'                 => $this->integer()->notNull(),
            'status'            => $this->integer()->notNull(),
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m171206_035646_schema cannot be reverted.\n";

        return false;
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

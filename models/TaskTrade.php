<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%task_trade}}".
 *
 * @property integer $id
 * @property integer $village_from_id
 * @property integer $village_to_id
 * @property integer $resource_group_id
 * @property integer $task_id
 *
 * @property ResourceGroup $resourceGroup
 * @property Task $task
 * @property Village $villageFrom
 * @property Village $villageTo
 */
class TaskTrade extends \app\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%task_trade}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['village_from_id', 'village_to_id', 'resource_group_id', 'task_id'], 'required'],
            [['village_from_id', 'village_to_id', 'resource_group_id', 'task_id'], 'integer'],
            [['task_id'], 'unique'],
            [['resource_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => ResourceGroup::className(), 'targetAttribute' => ['resource_group_id' => 'id']],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['task_id' => 'id']],
            [['village_from_id'], 'exist', 'skipOnError' => true, 'targetClass' => Village::className(), 'targetAttribute' => ['village_from_id' => 'id']],
            [['village_to_id'], 'exist', 'skipOnError' => true, 'targetClass' => Village::className(), 'targetAttribute' => ['village_to_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'village_from_id' => 'Village From ID',
            'village_to_id' => 'Village To ID',
            'resource_group_id' => 'Resource Group ID',
            'task_id' => 'Task ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResourceGroup()
    {
        return $this->hasOne(ResourceGroup::className(), ['id' => 'resource_group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::className(), ['id' => 'task_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVillageFrom()
    {
        return $this->hasOne(Village::className(), ['id' => 'village_from_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVillageTo()
    {
        return $this->hasOne(Village::className(), ['id' => 'village_to_id']);
    }
}
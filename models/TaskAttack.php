<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%task_attack}}".
 *
 * @property integer $id
 * @property integer $units_id
 * @property integer $resources_id
 * @property integer $task_id
 *
 * @property Units $units
 * @property Resources $resources
 * @property Task $task
 */
class TaskAttack extends \app\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%task_attack}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['units_id', 'resources_id', 'task_id'], 'required'],
            [['units_id', 'resources_id', 'task_id'], 'integer'],
            [['task_id'], 'unique'],
            [['units_id'], 'exist', 'skipOnError' => true, 'targetClass' => Units::className(), 'targetAttribute' => ['units_id' => 'id']],
            [['resources_id'], 'exist', 'skipOnError' => true, 'targetClass' => Resources::className(), 'targetAttribute' => ['resources_id' => 'id']],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['task_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'units_id' => 'Units ID',
            'resources_id' => 'Resources ID',
            'task_id' => 'Task ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnits()
    {
        return $this->hasOne(Units::className(), ['id' => 'units_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResources()
    {
        return $this->hasOne(Resources::className(), ['id' => 'resources_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::className(), ['id' => 'task_id']);
    }
}

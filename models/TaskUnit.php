<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%task_unit}}".
 *
 * @property integer $id
 * @property integer $village_id
 * @property integer $count
 * @property integer $unit_id
 * @property integer $task_id
 *
 * @property Task $task
 * @property Village $village
 */
class TaskUnit extends \app\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%task_unit}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['village_id', 'count', 'unit_id', 'task_id'], 'required'],
            [['village_id', 'count', 'unit_id', 'task_id'], 'integer'],
            [['task_id'], 'unique'],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['task_id' => 'id']],
            [['village_id'], 'exist', 'skipOnError' => true, 'targetClass' => Village::className(), 'targetAttribute' => ['village_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'village_id' => 'Village ID',
            'count' => 'Count',
            'unit_id' => 'Unit ID',
            'task_id' => 'Task ID',
        ];
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
    public function getVillage()
    {
        return $this->hasOne(Village::className(), ['id' => 'village_id']);
    }
}

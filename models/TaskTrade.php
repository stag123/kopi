<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%task_trade}}".
 *
 * @property integer $id
 * @property integer $resources_id
 * @property integer $task_id
 *
 * @property Resources $resources
 * @property Task $task
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
            [['resources_id', 'task_id'], 'required'],
            [['resources_id', 'task_id'], 'integer'],
            [['task_id'], 'unique'],
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
            'resources_id' => 'Resources ID',
            'task_id' => 'Task ID',
        ];
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

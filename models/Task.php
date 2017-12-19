<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%task}}".
 *
 * @property integer $id
 * @property string $created_at
 * @property string $updated_at
 * @property integer $duration
 * @property integer $status
 *
 * @property TaskAttack $taskAttack
 * @property TaskBuild $taskBuild
 * @property TaskTrade $taskTrade
 * @property TaskUnit $taskUnit
 */
class Task extends \app\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%task}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'safe'],
            [['duration'], 'required'],
            [['duration', 'status'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'duration' => 'Duration',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaskAttack()
    {
        return $this->hasOne(TaskAttack::className(), ['task_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaskBuild()
    {
        return $this->hasOne(TaskBuild::className(), ['task_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaskTrade()
    {
        return $this->hasOne(TaskTrade::className(), ['task_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaskUnit()
    {
        return $this->hasOne(TaskUnit::className(), ['task_id' => 'id']);
    }
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%task_build}}".
 *
 * @property integer $id
 * @property integer $village_id
 * @property integer $build_village_id
 * @property integer $task_id
 *
 * @property Task $task
 * @property BuildVillage $buildVillage
 * @property Village $village
 */
class TaskBuild extends \app\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%task_build}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['village_id', 'build_village_id', 'task_id'], 'required'],
            [['village_id', 'build_village_id', 'task_id'], 'integer'],
            [['task_id'], 'unique'],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['task_id' => 'id']],
            [['build_village_id'], 'exist', 'skipOnError' => true, 'targetClass' => BuildVillage::className(), 'targetAttribute' => ['build_village_id' => 'id']],
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
            'build_village_id' => 'Build Village ID',
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
    public function getBuildVillage()
    {
        return $this->hasOne(BuildVillage::className(), ['id' => 'build_village_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVillage()
    {
        return $this->hasOne(Village::className(), ['id' => 'village_id']);
    }
}

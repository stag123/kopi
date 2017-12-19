<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%task_build}}".
 *
 * @property integer $id
 * @property integer $village_id
 * @property integer $village_map_id
 * @property integer $build_id
 * @property integer $level
 * @property integer $task_id
 *
 * @property Task $task
 * @property VillageMap $villageMap
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
            [['village_id', 'village_map_id', 'build_id', 'task_id'], 'required'],
            [['village_id', 'village_map_id', 'build_id', 'level', 'task_id'], 'integer'],
            [['task_id'], 'unique'],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['task_id' => 'id']],
            [['village_map_id'], 'exist', 'skipOnError' => true, 'targetClass' => VillageMap::className(), 'targetAttribute' => ['village_map_id' => 'id']],
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
            'village_map_id' => 'Village Map ID',
            'build_id' => 'Build ID',
            'level' => 'Level',
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
    public function getVillageMap()
    {
        return $this->hasOne(VillageMap::className(), ['id' => 'village_map_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVillage()
    {
        return $this->hasOne(Village::className(), ['id' => 'village_id']);
    }
}

<?php

namespace app\models;

use app\components\village\build\models\Build;
use Yii;

/**
 * This is the model class for table "{{%task}}".
 *
 * @property integer $id
 * @property string $created_at
 * @property string $updated_at
 * @property integer $duration
 * @property integer $village_from_id
 * @property integer $village_to_id
 * @property integer $worker
 * @property integer $status
 *
 * @property TaskAttack $taskAttack
 * @property TaskBuild $taskBuild
 * @property TaskTrade $taskTrade
 * @property TaskUnit $taskUnit
 */
class Task extends \app\models\BaseModel
{

    const STATUS_NEW = 1;
    const STATUS_PROGRESS = 2;
    const STATUS_DONE = 3;
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
            [['duration', 'village_from_id', 'village_to_id'], 'required'],
            [['duration', 'village_from_id', 'village_to_id', 'worker', 'status'], 'integer'],
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
            'village_from_id' => 'Village From ID',
            'village_to_id' => 'Village To ID',
            'worker' => 'Worker',
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

    public static function freeTasks() {
        $condition = ['status' => self::STATUS_NEW];
        Task::updateAll(
            $condition,
            'status = '. self::STATUS_PROGRESS.' AND DATE_ADD(created_at, INTERVAL duration SECOND) < DATE_ADD(NOW(), INTERVAL -5 SECOND)'
        );
    }

    /**
     * @param $worker
     * @param $timeLeft
     * @return Task[]
     */
    public static function getTasks($worker, $timeLeft) {
        $condition = ['status' => self::STATUS_PROGRESS, 'worker' => $worker];
        Task::updateAll(
            $condition,
            'status = '. self::STATUS_NEW.' AND DATE_ADD(created_at, INTERVAL duration SECOND) >= DATE_ADD(NOW(), INTERVAL -'. $timeLeft. ' SECOND)'
        );
        $tasks = Task::find()->where($condition)->orderBy(['created_at' => SORT_ASC, 'id' => SORT_ASC])->all();
        return $tasks ?: [];
    }

    /**
     * @param $village_id
     * @return Task[]
     */
    public static function getVillageTasks($village_id) {
        /** @var Task[] $tasks */
        $tasks = Task::find()
            ->with('taskBuild', 'taskAttack', 'taskTrade', 'taskUnit')
            ->orWhere(['village_from_id' => $village_id, 'village_to_id' => $village_id, 'status' => [self::STATUS_NEW, self::STATUS_PROGRESS]])
            ->all();
        $data = [];
        $tasks = $tasks ?: [];
        foreach($tasks as $task) {
            if ($task->taskBuild) {
                $data[] = [
                    'time_left' => strtotime($task->created_at) + $task->duration - time(),
                    'build' => Build::GetByID($task->taskBuild->build_id),
                    'level' => $task->taskBuild->level
                ];
            }
          // $task->
            //$data[]
        }
        return $data ?: [];
    }

    public function done() {
        $this->status = self::STATUS_DONE;
        $this->save();
    }
}

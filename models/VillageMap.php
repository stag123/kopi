<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%village_map}}".
 *
 * @property integer $id
 * @property integer $x
 * @property integer $y
 * @property integer $level
 * @property integer $build_id
 * @property integer $village_id
 * @property integer $type
 * @property integer $status
 *
 * @property TaskBuild[] $taskBuilds
 * @property Build $build
 * @property Village $village
 */
class VillageMap extends \app\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%village_map}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['x', 'y', 'village_id', 'type', 'status'], 'required'],
            [['x', 'y', 'level', 'build_id', 'village_id', 'type', 'status'], 'integer'],
            [['x', 'y', 'village_id'], 'unique', 'targetAttribute' => ['x', 'y', 'village_id'], 'message' => 'The combination of X, Y and Village ID has already been taken.'],
            [['build_id'], 'exist', 'skipOnError' => true, 'targetClass' => Build::className(), 'targetAttribute' => ['build_id' => 'id']],
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
            'x' => 'X',
            'y' => 'Y',
            'level' => 'Level',
            'build_id' => 'Build ID',
            'village_id' => 'Village ID',
            'type' => 'Type',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaskBuilds()
    {
        return $this->hasMany(TaskBuild::className(), ['village_map_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBuild()
    {
        return $this->hasOne(Build::className(), ['id' => 'build_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVillage()
    {
        return $this->hasOne(Village::className(), ['id' => 'village_id']);
    }
}

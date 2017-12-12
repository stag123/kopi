<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%resource}}".
 *
 * @property integer $id
 * @property integer $wood
 * @property integer $grain
 * @property integer $iron
 * @property integer $stone
 *
 * @property Build[] $builds
 * @property Build $build
 * @property TaskTrade[] $taskTrades
 * @property Unit[] $units
 * @property Unit $unit
 * @property Village $village
 */
class Resource extends \app\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%resource}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['wood', 'grain', 'iron', 'stone'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'wood' => 'Wood',
            'grain' => 'Grain',
            'iron' => 'Iron',
            'stone' => 'Stone',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBuilds()
    {
        return $this->hasMany(Build::className(), ['change_resource_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBuild()
    {
        return $this->hasOne(Build::className(), ['price_resource_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaskTrades()
    {
        return $this->hasMany(TaskTrade::className(), ['resource_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnits()
    {
        return $this->hasMany(Unit::className(), ['change_resource_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnit()
    {
        return $this->hasOne(Unit::className(), ['price_resource_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVillage()
    {
        return $this->hasOne(Village::className(), ['village_resource_id' => 'id']);
    }
}

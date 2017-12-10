<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%resource_group}}".
 *
 * @property integer $id
 *
 * @property Build[] $builds
 * @property Build $build
 * @property ResourceValue[] $resourceValues
 * @property Resource[] $resources
 * @property TaskTrade[] $taskTrades
 * @property Unit[] $units
 * @property Unit $unit
 * @property Village $village
 */
class ResourceGroup extends \app\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%resource_group}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
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
    public function getResourceValues()
    {
        return $this->hasMany(ResourceValue::className(), ['group_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResources()
    {
        return $this->hasMany(Resource::className(), ['id' => 'resource_id'])->viaTable('{{%resource_value}}', ['group_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaskTrades()
    {
        return $this->hasMany(TaskTrade::className(), ['resource_group_id' => 'id']);
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

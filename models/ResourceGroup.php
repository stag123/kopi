<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%resource_group}}".
 *
 * @property integer $id
 *
 * @property BuildInfo $buildInfo
 * @property ResourceValue[] $resourceValues
 * @property Resource[] $resources
 * @property TaskTrade[] $taskTrades
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
        return [];
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
    public function getBuildInfo()
    {
        return $this->hasOne(BuildInfo::className(), ['price_resource_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResourceValues()
    {
        return $this->hasMany(ResourceValue::className(), ['resource_group_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResources()
    {
        return $this->hasMany(Resource::className(), ['id' => 'resource_id'])->viaTable('{{%resource_value}}', ['resource_group_id' => 'id']);
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

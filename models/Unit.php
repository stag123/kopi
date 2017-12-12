<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%unit}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property integer $speed
 * @property integer $price_resource_id
 * @property integer $resource_capacity
 * @property integer $attack
 * @property integer $defence
 * @property integer $attack_archer
 * @property integer $defence_archer
 * @property integer $attack_horse
 * @property integer $defence_horse
 * @property integer $change_resource_id
 * @property integer $build_time
 *
 * @property Resource $changeResource
 * @property Resource $priceResource
 * @property UnitValue[] $unitValues
 * @property UnitGroup[] $unitGroups
 */
class Unit extends \app\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%unit}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['speed', 'price_resource_id', 'resource_capacity', 'attack', 'defence', 'attack_archer', 'defence_archer', 'attack_horse', 'defence_horse', 'change_resource_id', 'build_time'], 'required'],
            [['speed', 'price_resource_id', 'resource_capacity', 'attack', 'defence', 'attack_archer', 'defence_archer', 'attack_horse', 'defence_horse', 'change_resource_id', 'build_time'], 'integer'],
            [['name', 'code'], 'string', 'max' => 255],
            [['price_resource_id'], 'unique'],
            [['change_resource_id'], 'exist', 'skipOnError' => true, 'targetClass' => Resource::className(), 'targetAttribute' => ['change_resource_id' => 'id']],
            [['price_resource_id'], 'exist', 'skipOnError' => true, 'targetClass' => Resource::className(), 'targetAttribute' => ['price_resource_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'code' => 'Code',
            'speed' => 'Speed',
            'price_resource_id' => 'Price Resource ID',
            'resource_capacity' => 'Resource Capacity',
            'attack' => 'Attack',
            'defence' => 'Defence',
            'attack_archer' => 'Attack Archer',
            'defence_archer' => 'Defence Archer',
            'attack_horse' => 'Attack Horse',
            'defence_horse' => 'Defence Horse',
            'change_resource_id' => 'Change Resource ID',
            'build_time' => 'Build Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChangeResource()
    {
        return $this->hasOne(Resource::className(), ['id' => 'change_resource_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPriceResource()
    {
        return $this->hasOne(Resource::className(), ['id' => 'price_resource_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnitValues()
    {
        return $this->hasMany(UnitValue::className(), ['unit_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnitGroups()
    {
        return $this->hasMany(UnitGroup::className(), ['id' => 'unit_group_id'])->viaTable('{{%unit_value}}', ['unit_id' => 'id']);
    }
}

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
 * @property integer $price_resources_id
 * @property integer $resources_capacity
 * @property integer $attack
 * @property integer $defence
 * @property integer $attack_archer
 * @property integer $defence_archer
 * @property integer $attack_horse
 * @property integer $defence_horse
 * @property integer $change_resources_id
 * @property integer $build_time
 *
 * @property Resources $changeResources
 * @property Resources $priceResources
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
            [['speed', 'price_resources_id', 'resources_capacity', 'attack', 'defence', 'attack_archer', 'defence_archer', 'attack_horse', 'defence_horse', 'change_resources_id', 'build_time'], 'required'],
            [['speed', 'price_resources_id', 'resources_capacity', 'attack', 'defence', 'attack_archer', 'defence_archer', 'attack_horse', 'defence_horse', 'change_resources_id', 'build_time'], 'integer'],
            [['name', 'code'], 'string', 'max' => 255],
            [['price_resources_id'], 'unique'],
            [['change_resources_id'], 'exist', 'skipOnError' => true, 'targetClass' => Resources::className(), 'targetAttribute' => ['change_resources_id' => 'id']],
            [['price_resources_id'], 'exist', 'skipOnError' => true, 'targetClass' => Resources::className(), 'targetAttribute' => ['price_resources_id' => 'id']],
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
            'price_resources_id' => 'Price Resources ID',
            'resources_capacity' => 'Resources Capacity',
            'attack' => 'Attack',
            'defence' => 'Defence',
            'attack_archer' => 'Attack Archer',
            'defence_archer' => 'Defence Archer',
            'attack_horse' => 'Attack Horse',
            'defence_horse' => 'Defence Horse',
            'change_resources_id' => 'Change Resources ID',
            'build_time' => 'Build Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChangeResources()
    {
        return $this->hasOne(Resources::className(), ['id' => 'change_resources_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPriceResources()
    {
        return $this->hasOne(Resources::className(), ['id' => 'price_resources_id']);
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

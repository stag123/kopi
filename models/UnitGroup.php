<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%unit_group}}".
 *
 * @property integer $id
 * @property integer $village_id
 * @property integer $map_id
 *
 * @property TaskAttack[] $taskAttacks
 * @property Map $map
 * @property Village $village
 * @property UnitValue[] $unitValues
 * @property Unit[] $units
 */
class UnitGroup extends \app\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%unit_group}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['village_id'], 'required'],
            [['village_id', 'map_id'], 'integer'],
            [['map_id'], 'exist', 'skipOnError' => true, 'targetClass' => Map::className(), 'targetAttribute' => ['map_id' => 'id']],
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
            'map_id' => 'Map ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaskAttacks()
    {
        return $this->hasMany(TaskAttack::className(), ['unit_group_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMap()
    {
        return $this->hasOne(Map::className(), ['id' => 'map_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVillage()
    {
        return $this->hasOne(Village::className(), ['id' => 'village_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnitValues()
    {
        return $this->hasMany(UnitValue::className(), ['unit_group_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnits()
    {
        return $this->hasMany(Unit::className(), ['id' => 'unit_id'])->viaTable('{{%unit_value}}', ['unit_group_id' => 'id']);
    }
}

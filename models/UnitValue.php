<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%unit_value}}".
 *
 * @property integer $id
 * @property integer $unit_id
 * @property integer $unit_group_id
 * @property integer $value
 *
 * @property Unit $unit
 * @property UnitGroup $unitGroup
 */
class UnitValue extends \app\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%unit_value}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['unit_id', 'unit_group_id', 'value'], 'required'],
            [['unit_id', 'unit_group_id', 'value'], 'integer'],
            [['unit_id', 'unit_group_id'], 'unique', 'targetAttribute' => ['unit_id', 'unit_group_id'], 'message' => 'The combination of Unit ID and Unit Group ID has already been taken.'],
            [['unit_id'], 'exist', 'skipOnError' => true, 'targetClass' => Unit::className(), 'targetAttribute' => ['unit_id' => 'id']],
            [['unit_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => UnitGroup::className(), 'targetAttribute' => ['unit_group_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'unit_id' => 'Unit ID',
            'unit_group_id' => 'Unit Group ID',
            'value' => 'Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnit()
    {
        return $this->hasOne(Unit::className(), ['id' => 'unit_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnitGroup()
    {
        return $this->hasOne(UnitGroup::className(), ['id' => 'unit_group_id']);
    }
}

<?php

namespace app\models;

use app\components\village\build\unit\models\Unit;
use Yii;

/**
 * This is the model class for table "{{%units}}".
 *
 * @property integer $id
 * @property integer $village_id
 * @property integer $map_id
 * @property integer $sword
 * @property integer $catapult
 *
 * @property TaskAttack[] $taskAttacks
 * @property Map $map
 * @property Village $village
 * @property Village[] $villages
 */
class Units extends \app\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%units}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['village_id'], 'required'],
            [['village_id', 'map_id', 'sword', 'catapult'], 'integer'],
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
            'sword' => 'Sword',
            'catapult' => 'Catapult',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaskAttacks()
    {
        return $this->hasMany(TaskAttack::className(), ['units_id' => 'id']);
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
    public function getVillages()
    {
        return $this->hasMany(Village::className(), ['village_units_id' => 'id']);
    }

    public function greaterThen(Units $r) {
        return $this->sword >= $r->sword
        && $this->catapult >= $r->catapult;
    }

    public function add(Units $r) {
        $this->sword += $r->sword;
        $this->catapult += $r->catapult;
        $this->save();
    }

    public function remove(Units $r) {
        $this->sword -= $r->sword;
        $this->catapult -= $r->catapult;
        $this->save();
    }

    public function getSmallestSpeed() {
        $speed = [];
        if ($this->sword > 0) {
            $speed[] = Unit::getSword()->speed;
        }

        if ($this->catapult > 0) {
            $speed[] = Unit::getCatapult()->speed;
        }

        return min($speed);
    }
}

<?php

namespace app\models;

use app\components\village\build\unit\models\Unit;

/**
 * This is the model class for table "{{%units}}".
 *
 * @property integer $id
 * @property integer $village_id
 * @property integer $map_id
 * @property integer $sword
 * @property integer $catapult
 * @property integer $archer
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
            [array_merge(['village_id', 'map_id'], Unit::GetTypes()), 'integer'],
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

    public function exist() {
        foreach(Unit::GetTypes() as $type) {
            if ($this->{$type}) {
                return true;
            }
        }
        return false;
    }

    public function greaterThen(Units $r) {
        foreach(Unit::GetTypes() as $type) {
            if ($this->{$type} < $r->{$type}) {
                return false;
            }
        }
        return true;
    }

    public function add(Units $r) {
        foreach(Unit::GetTypes() as $type) {
            $this->{$type} += $r->{$type};
        }
        $this->save();
    }

    public function remove(Units $r) {
        foreach(Unit::GetTypes() as $type) {
            $this->{$type} -= $r->{$type};
        }
        $this->save();
    }

    public function removePercent($percent) {
        foreach(Unit::GetTypes() as $type) {
            $this->{$type} -= ceil($this->{$type} * $percent);
        }
        $this->save();
    }

    public function getSmallestSpeed() {
        $speed = [];
        foreach(Unit::GetTypes() as $type) {
            if ($this->{$type} > 0) {
                $speed[] = Unit::GetByCode($type)->speed;
            }
        }

        return min($speed);
    }

    public function toNumbers() {
        $result = [];
        foreach($this->toArray(Unit::GetTypes()) as $key => $value) {
            $result[$key] = $value;
        }
        return $result;
    }

    public function getDefence() {
        $result = 0;
        foreach(Unit::GetTypes() as $type) {
            $result += Unit::GetByCode($type)->defence * $this->{$type};
        }
        return $result;
    }

    public function getAttack() {
        $result = 0;
        foreach(Unit::GetTypes() as $type) {
            $result += Unit::GetByCode($type)->attack * $this->{$type};
        }
        return $result;
    }

    public function getArcherDefence() {
        $result = 0;
        foreach(Unit::GetTypes() as $type) {
            $result += Unit::GetByCode($type)->defenceArcher * $this->{$type};
        }
        return $result;
    }

    public function getHorseDefence() {
        $result = 0;
        foreach(Unit::GetTypes() as $type) {
            $result += Unit::GetByCode($type)->defenceHorse * $this->{$type};
        }
        return $result;
    }


    public function getHorseAttack() {
        $result = 0;
        foreach(Unit::GetTypes() as $type) {
            $result += Unit::GetByCode($type)->attackHorse * $this->{$type};
        }
        return $result;
    }

    public function getAcrherAttack() {
        $result = 0;
        foreach(Unit::GetTypes() as $type) {
            $result += Unit::GetByCode($type)->attackArcher * $this->{$type};
        }
        return $result;
    }

    public function getBag() {
        $result = 0;
        foreach(Unit::GetTypes() as $type) {
            $result += Unit::GetByCode($type)->bag * $this->{$type};
        }
        return $result;
    }

    public function getDamage() {
        $result = 0;
        foreach(Unit::GetTypes() as $type) {
            $result += Unit::GetByCode($type)->damage * $this->{$type};
        }
        return $result;
    }

    public function __toString()
    {
        return json_encode($this->toArray());
    }

}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%resources}}".
 *
 * @property integer $id
 * @property double $wood
 * @property double $grain
 * @property double $iron
 * @property double $stone
 *
 * @property TaskAttack[] $taskAttacks
 * @property TaskTrade[] $taskTrades
 * @property Village $village
 */
class Resources extends \app\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%resources}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['wood', 'grain', 'iron', 'stone'], 'number'],
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
    public function getTaskAttacks()
    {
        return $this->hasMany(TaskAttack::className(), ['resources_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaskTrades()
    {
        return $this->hasMany(TaskTrade::className(), ['resources_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVillage()
    {
        return $this->hasOne(Village::className(), ['village_resources_id' => 'id']);
    }

    public function greaterThen(Resources $r) {
        return $this->grain >= $r->grain
        && $this->wood >= $r->wood
        && $this->iron >= $r->iron
        && $this->stone >= $r->stone;
    }

    public function add(Resources $r) {
        $this->grain += $r->grain;
        $this->wood += $r->wood;
        $this->iron += $r->iron;
        $this->stone += $r->stone;
        $this->save();
    }

    public function remove(Resources $r) {
        $this->grain -= $r->grain;
        $this->wood -= $r->wood;
        $this->iron -= $r->iron;
        $this->stone -= $r->stone;
        $this->save();
    }

    public function multiply($count) {
        $this->grain *= $count;
        $this->wood *= $count;
        $this->iron *= $count;
        $this->stone *= $count;
        return $this;
    }

    public function steal($count, $resource = null) {
        if (!$resource) {
            $resource = new Resources();
        }
        $partCount = (($this->grain > 0) + ($this->wood > 0) + ($this->iron > 0) + ($this->stone > 0));
        if (!$partCount) {
            return $resource;
        }
        $this->logger->info('Part Count: ' . $partCount);
        $part = $count / $partCount;
        if ($this->grain >= $part) {
            $this->grain -= $part;
            $resource->grain += $part;
            $count -= $part;
        } else {
            $count -= $this->grain;
            $resource->grain += $this->grain;
            $this->grain = 0;
        }
        if ($this->wood >= $part) {
            $this->wood -= $part;
            $resource->wood += $part;
            $count -= $part;
        } else {
            $count -= $this->wood;
            $resource->wood += $this->wood;
            $this->wood = 0;
        }
        if ($this->iron >= $part) {
            $this->iron -= $part;
            $resource->iron += $part;
            $count -= $part;
        } else {
            $resource->iron += $this->iron;
            $count -= $this->iron;
            $this->iron = 0;
        }
        if ($this->stone >= $part) {
            $this->stone -= $part;
            $resource->stone += $part;
            $count -= $part;
        } else {
            $count -= $this->stone;
            $resource->stone += $this->stone;
            $this->stone = 0;
        }
        $this->save();
        if ($count > 0) {
            return $this->steal($count, $resource);
        }
        return $resource;
    }

    public function __toString()
    {
        return json_encode($this->toArray());
    }
}

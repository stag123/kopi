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
}

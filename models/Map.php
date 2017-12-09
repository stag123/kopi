<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%map}}".
 *
 * @property integer $id
 * @property integer $x
 * @property integer $y
 * @property integer $type
 * @property integer $status
 *
 * @property UnitGroup[] $unitGroups
 * @property Village $village
 */
class Map extends \app\models\BaseModel
{
    const STATUS_VILLAGE = 1;
    const STATUS_FREE = 2;

    const SIZE = 20;
    const TYPE_COUNT = 10;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%map}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['x', 'y', 'type', 'status'], 'required'],
            [['x', 'y', 'type', 'status'], 'integer'],
            [['x', 'y'], 'unique', 'targetAttribute' => ['x', 'y'], 'message' => 'The combination of X and Y has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'x' => 'X',
            'y' => 'Y',
            'type' => 'Type',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnitGroups()
    {
        return $this->hasMany(UnitGroup::className(), ['map_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVillage()
    {
        return $this->hasOne(Village::className(), ['map_id' => 'id']);
    }

    public static function generate() {
        for ($i = 0; $i < self::SIZE; $i++) {
            for ($j = 0; $j < self::SIZE; $j++) {
                $map = new self;
                $map->x = $i + 1;
                $map->y = $j + 1;
                $map->type = rand(1, self::TYPE_COUNT);
                $map->status = self::STATUS_FREE;
                $map->save();
            }
        }
    }

    /**
     * @return array|null|\yii\db\ActiveRecord
     */
    public static function findFree() {
        $count = static::find()->where(['status' => self::STATUS_FREE])->count();
        if ($count < self::SIZE * self::SIZE * 0.1) {
            return null;
        }
        return static::find()->where(['status' => self::STATUS_FREE])->offset(rand(1, $count))->one();
    }
}

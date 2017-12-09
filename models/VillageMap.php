<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%village_map}}".
 *
 * @property integer $id
 * @property integer $x
 * @property integer $y
 *
 * @property BuildVillage[] $buildVillages
 * @property Village[] $villages
 */
class VillageMap extends \app\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%village_map}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['x', 'y'], 'required'],
            [['x', 'y'], 'integer'],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBuildVillages()
    {
        return $this->hasMany(BuildVillage::className(), ['village_map_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVillages()
    {
        return $this->hasMany(Village::className(), ['id' => 'village_id'])->viaTable('{{%build_village}}', ['village_map_id' => 'id']);
    }
}

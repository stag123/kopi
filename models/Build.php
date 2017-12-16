<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%build}}".
 *
 * @property integer $id
 * @property integer $map_type
 * @property string $name
 * @property string $description
 * @property string $code
 *
 * @property VillageMap[] $villageMaps
 */
class Build extends \app\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%build}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['map_type'], 'required'],
            [['map_type'], 'integer'],
            [['name', 'description', 'code'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'map_type' => 'Map Type',
            'name' => 'Name',
            'description' => 'Description',
            'code' => 'Code',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVillageMaps()
    {
        return $this->hasMany(VillageMap::className(), ['build_id' => 'id']);
    }
}

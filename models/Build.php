<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%build}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 *
 * @property BuildInfo[] $buildInfos
 * @property BuildVillage[] $buildVillages
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
            [['name', 'code'], 'string', 'max' => 255],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBuildInfos()
    {
        return $this->hasMany(BuildInfo::className(), ['build_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBuildVillages()
    {
        return $this->hasMany(BuildVillage::className(), ['build_id' => 'id']);
    }
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%build}}".
 *
 * @property integer $id
 * @property integer $level
 * @property integer $type_id
 * @property integer $price_resource_id
 * @property integer $build_time
 * @property integer $change_resource_id
 *
 * @property Resource $changeResource
 * @property Resource $priceResource
 * @property BuildType $type
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
            [['level', 'type_id', 'price_resource_id', 'build_time', 'change_resource_id'], 'required'],
            [['level', 'type_id', 'price_resource_id', 'build_time', 'change_resource_id'], 'integer'],
            [['price_resource_id'], 'unique'],
            [['type_id', 'level'], 'unique', 'targetAttribute' => ['type_id', 'level'], 'message' => 'The combination of Level and Type ID has already been taken.'],
            [['change_resource_id'], 'exist', 'skipOnError' => true, 'targetClass' => Resource::className(), 'targetAttribute' => ['change_resource_id' => 'id']],
            [['price_resource_id'], 'exist', 'skipOnError' => true, 'targetClass' => Resource::className(), 'targetAttribute' => ['price_resource_id' => 'id']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => BuildType::className(), 'targetAttribute' => ['type_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'level' => 'Level',
            'type_id' => 'Type ID',
            'price_resource_id' => 'Price Resource ID',
            'build_time' => 'Build Time',
            'change_resource_id' => 'Change Resource ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChangeResource()
    {
        return $this->hasOne(Resource::className(), ['id' => 'change_resource_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPriceResource()
    {
        return $this->hasOne(Resource::className(), ['id' => 'price_resource_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(BuildType::className(), ['id' => 'type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBuildVillages()
    {
        return $this->hasMany(BuildVillage::className(), ['build_id' => 'id']);
    }
}

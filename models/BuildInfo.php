<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%build_info}}".
 *
 * @property integer $id
 * @property integer $level
 * @property integer $build_id
 * @property integer $price_resource_id
 * @property integer $cost
 * @property integer $build_time
 *
 * @property Build $build
 * @property ResourceGroup $priceResource
 */
class BuildInfo extends \app\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%build_info}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['level', 'build_id', 'price_resource_id', 'cost', 'build_time'], 'required'],
            [['level', 'build_id', 'price_resource_id', 'cost', 'build_time'], 'integer'],
            [['price_resource_id'], 'unique'],
            [['build_id', 'level'], 'unique', 'targetAttribute' => ['build_id', 'level'], 'message' => 'The combination of Level and Build ID has already been taken.'],
            [['build_id'], 'exist', 'skipOnError' => true, 'targetClass' => Build::className(), 'targetAttribute' => ['build_id' => 'id']],
            [['price_resource_id'], 'exist', 'skipOnError' => true, 'targetClass' => ResourceGroup::className(), 'targetAttribute' => ['price_resource_id' => 'id']],
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
            'build_id' => 'Build ID',
            'price_resource_id' => 'Price Resource ID',
            'cost' => 'Cost',
            'build_time' => 'Build Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBuild()
    {
        return $this->hasOne(Build::className(), ['id' => 'build_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPriceResource()
    {
        return $this->hasOne(ResourceGroup::className(), ['id' => 'price_resource_id']);
    }
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%resource_value}}".
 *
 * @property integer $id
 * @property integer $resource_id
 * @property integer $resource_group_id
 * @property integer $value
 *
 * @property ResourceGroup $resourceGroup
 * @property Resource $resource
 */
class ResourceValue extends \app\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%resource_value}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['resource_id', 'resource_group_id', 'value'], 'required'],
            [['resource_id', 'resource_group_id', 'value'], 'integer'],
            [['resource_id', 'resource_group_id'], 'unique', 'targetAttribute' => ['resource_id', 'resource_group_id'], 'message' => 'The combination of Resource ID and Resource Group ID has already been taken.'],
            [['resource_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => ResourceGroup::className(), 'targetAttribute' => ['resource_group_id' => 'id']],
            [['resource_id'], 'exist', 'skipOnError' => true, 'targetClass' => Resource::className(), 'targetAttribute' => ['resource_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'resource_id' => 'Resource ID',
            'resource_group_id' => 'Resource Group ID',
            'value' => 'Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResourceGroup()
    {
        return $this->hasOne(ResourceGroup::className(), ['id' => 'resource_group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResource()
    {
        return $this->hasOne(Resource::className(), ['id' => 'resource_id']);
    }
}

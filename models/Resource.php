<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%resource}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 *
 * @property ResourceValue[] $resourceValues
 * @property ResourceGroup[] $groups
 */
class Resource extends \app\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%resource}}';
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
    public function getResourceValues()
    {
        return $this->hasMany(ResourceValue::className(), ['resource_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroups()
    {
        return $this->hasMany(ResourceGroup::className(), ['id' => 'group_id'])->viaTable('{{%resource_value}}', ['resource_id' => 'id']);
    }
}

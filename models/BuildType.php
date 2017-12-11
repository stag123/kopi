<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%build_type}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 *
 * @property Build[] $builds
 */
class BuildType extends \app\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%build_type}}';
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
    public function getBuilds()
    {
        return $this->hasMany(Build::className(), ['type_id' => 'id']);
    }
}

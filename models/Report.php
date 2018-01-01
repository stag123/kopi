<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%report}}".
 *
 * @property integer $id
 * @property integer $type
 * @property integer $user_id
 * @property integer $village_id
 * @property string $title
 * @property string $details
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User $user
 * @property Village $village
 */
class Report extends \app\models\BaseModel
{

    const TYPE_ATTACK = 1;
    const TYPE_DEFENCE = 2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%report}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'user_id', 'village_id', 'title'], 'required'],
            [['type', 'user_id', 'village_id'], 'integer'],
            [['details'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['village_id'], 'exist', 'skipOnError' => true, 'targetClass' => Village::className(), 'targetAttribute' => ['village_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'user_id' => 'User ID',
            'village_id' => 'Village ID',
            'title' => 'Title',
            'details' => 'Details',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVillage()
    {
        return $this->hasOne(Village::className(), ['id' => 'village_id']);
    }
}

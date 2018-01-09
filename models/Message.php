<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%message}}".
 *
 * @property integer $id
 * @property integer $status
 * @property integer $user_from_id
 * @property integer $user_to_id
 * @property string $title
 * @property string $text
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User $userTo
 * @property User $userFrom
 */
class Message extends \app\models\BaseModel
{
    const STATUS_NOREAD = 0;
    const STATUS_READ = 1;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%message}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'user_from_id', 'user_to_id'], 'integer'],
            [['user_from_id', 'user_to_id'], 'required'],
            [['text'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['user_to_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_to_id' => 'id']],
            [['user_from_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_from_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => 'Status',
            'userFrom.username' => 'От',
            'userTo.username' => 'Кому',
            'title' => 'Заголовок',
            'text' => 'Сообщение',
            'created_at' => 'Дата',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserTo()
    {
        return $this->hasOne(User::className(), ['id' => 'user_to_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserFrom()
    {
        return $this->hasOne(User::className(), ['id' => 'user_from_id']);
    }
}

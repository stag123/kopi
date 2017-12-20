<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%village}}".
 *
 * @property integer $id
 * @property integer $map_id
 * @property integer $user_id
 * @property string $name
 * @property integer $village_resources_id
 * @property string $created_at
 * @property integer $resources_updated_at
 *
 * @property UnitGroup[] $unitGroups
 * @property Resources $villageResources
 * @property Map $map
 * @property User $user
 * @property VillageMap[] $villageMaps
 */
class Village extends \app\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%village}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['map_id', 'user_id', 'village_resources_id'], 'required'],
            [['map_id', 'user_id', 'village_resources_id', 'resources_updated_at'], 'integer'],
            [['created_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['map_id'], 'unique'],
            [['village_resources_id'], 'unique'],
            [['village_resources_id'], 'exist', 'skipOnError' => true, 'targetClass' => Resources::className(), 'targetAttribute' => ['village_resources_id' => 'id']],
            [['map_id'], 'exist', 'skipOnError' => true, 'targetClass' => Map::className(), 'targetAttribute' => ['map_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'map_id' => 'Map ID',
            'user_id' => 'User ID',
            'name' => 'Name',
            'village_resources_id' => 'Village Resources ID',
            'created_at' => 'Created At',
            'resources_updated_at' => 'Resources Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnitGroups()
    {
        return $this->hasMany(UnitGroup::className(), ['village_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVillageResources()
    {
        return $this->hasOne(Resources::className(), ['id' => 'village_resources_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMap()
    {
        return $this->hasOne(Map::className(), ['id' => 'map_id']);
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
    public function getVillageMaps()
    {
        return $this->hasMany(VillageMap::className(), ['village_id' => 'id']);
    }
}

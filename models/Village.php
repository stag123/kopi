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
 * @property integer $village_resource_id
 *
 * @property BuildVillage[] $buildVillages
 * @property VillageMap[] $villageMaps
 * @property TaskAttack[] $taskAttacks
 * @property TaskAttack[] $taskAttacks0
 * @property TaskBuild[] $taskBuilds
 * @property TaskTrade[] $taskTrades
 * @property TaskTrade[] $taskTrades0
 * @property TaskUnit[] $taskUnits
 * @property UnitGroup[] $unitGroups
 * @property ResourceGroup $villageResource
 * @property Map $map
 * @property User $user
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
            [['map_id', 'user_id', 'village_resource_id'], 'required'],
            [['map_id', 'user_id', 'village_resource_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['map_id'], 'unique'],
            [['village_resource_id'], 'unique'],
            [['village_resource_id'], 'exist', 'skipOnError' => true, 'targetClass' => ResourceGroup::className(), 'targetAttribute' => ['village_resource_id' => 'id']],
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
            'village_resource_id' => 'Village Resource ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBuildVillages()
    {
        return $this->hasMany(BuildVillage::className(), ['village_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVillageMaps()
    {
        return $this->hasMany(VillageMap::className(), ['id' => 'village_map_id'])->viaTable('{{%build_village}}', ['village_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaskAttacks()
    {
        return $this->hasMany(TaskAttack::className(), ['village_from_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaskAttacks0()
    {
        return $this->hasMany(TaskAttack::className(), ['village_to_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaskBuilds()
    {
        return $this->hasMany(TaskBuild::className(), ['village_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaskTrades()
    {
        return $this->hasMany(TaskTrade::className(), ['village_from_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaskTrades0()
    {
        return $this->hasMany(TaskTrade::className(), ['village_to_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaskUnits()
    {
        return $this->hasMany(TaskUnit::className(), ['village_id' => 'id']);
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
    public function getVillageResource()
    {
        return $this->hasOne(ResourceGroup::className(), ['id' => 'village_resource_id']);
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
}

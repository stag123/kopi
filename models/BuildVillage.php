<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%build_village}}".
 *
 * @property integer $id
 * @property integer $build_id
 * @property integer $village_map_id
 *
 * @property VillageMap $villageMap
 * @property Build $build
 * @property TaskBuild[] $taskBuilds
 */
class BuildVillage extends \app\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%build_village}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['build_id', 'village_map_id'], 'required'],
            [['build_id', 'village_map_id'], 'integer'],
            [['village_map_id'], 'unique'],
            [['village_map_id'], 'exist', 'skipOnError' => true, 'targetClass' => VillageMap::className(), 'targetAttribute' => ['village_map_id' => 'id']],
            [['build_id'], 'exist', 'skipOnError' => true, 'targetClass' => Build::className(), 'targetAttribute' => ['build_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'build_id' => 'Build ID',
            'village_map_id' => 'Village Map ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVillageMap()
    {
        return $this->hasOne(VillageMap::className(), ['id' => 'village_map_id']);
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
    public function getTaskBuilds()
    {
        return $this->hasMany(TaskBuild::className(), ['build_village_id' => 'id']);
    }
}

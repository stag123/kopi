<?php

namespace app\models;

use app\components\village\build\models\Build;
use app\components\village\build\models\GrainFarm;
use app\components\village\build\models\Granary;
use app\components\village\build\models\IronFarm;
use app\components\village\build\models\Stock;
use app\components\village\build\models\StoneFarm;
use app\components\village\build\models\WoodFarm;
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
 * @property Task[] $tasks
 * @property Task[] $tasks0
 * @property Units[] $units
 * @property Map $map
 * @property Resources $villageResources
 * @property User $user
 * @property VillageMap[] $villageMaps
 */
class Village extends \app\models\BaseModel
{
    const BASE_STOCK = 500;
    const BASE_GRANARY = 400;
    const BASE_RESOURCE_SPEED = 6000;//VillageMap::RESOURCE_COUNT;
    const NEW_VILLAGE_RESOURCE = 200;
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
            [['map_id'], 'exist', 'skipOnError' => true, 'targetClass' => Map::className(), 'targetAttribute' => ['map_id' => 'id']],
            [['village_resources_id'], 'exist', 'skipOnError' => true, 'targetClass' => Resources::className(), 'targetAttribute' => ['village_resources_id' => 'id']],
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
            'village_units_id' => 'Village Units ID',
            'name' => 'Name',
            'village_resources_id' => 'Village Resources ID',
            'created_at' => 'Created At',
            'resources_updated_at' => 'Resources Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnits()
    {
        return $this->hasMany(Units::className(), ['village_id' => 'id']);
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
    public function getVillageResources()
    {
        return $this->hasOne(Resources::className(), ['id' => 'village_resources_id']);
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

    /**
     * @return int
     */
    public function getStockSize()
    {
        $maps = $this->getVillageMaps()->where(['build_id' => Build::ID_STOCK])->all();
        if ($maps) {
            $result = 0;
            foreach($maps as $map) {
                $result += Stock::getByLevel($map->level)->size;
            }
            return $result;
        }
        return self::BASE_STOCK;
    }

    /**
     * @return int
     */
    public function getGranarySize() {
        $maps = $this->getVillageMaps()->where(['build_id' => Build::ID_GRANARY])->all();
        if ($maps) {
            $result = 0;
            foreach($maps as $map) {
                $result += Stock::getByLevel($map->level)->size;
            }
            return $result;
        }
        return self::BASE_GRANARY;
    }

    /**
     * @return Resources
     */
    public function getResourceHour() {
        /** @var VillageMap[] $maps */
        $maps = $this->getVillageMaps()->where(['build_id' => [
            Build::ID_IRON_FARM,
            Build::ID_STONE_FARM,
            Build::ID_GRAIN_FARM,
            Build::ID_WOOD_FARM
        ]])->all();

        $res = new Resources();

        foreach ($maps as $map) {
            switch ($map->build_id) {
                case Build::ID_GRAIN_FARM:
                    $res->add(GrainFarm::getByLevel($map->level)->changeResource);
                    break;
                case Build::ID_STONE_FARM:
                    $res->add(StoneFarm::getByLevel($map->level)->changeResource);
                    break;
                case Build::ID_WOOD_FARM:
                    $res->add(WoodFarm::getByLevel($map->level)->changeResource);
                    break;
                case Build::ID_IRON_FARM:
                    $res->add(IronFarm::getByLevel($map->level)->changeResource);
                    break;
            }
        }
        $res->grain = max(self::BASE_RESOURCE_SPEED, $res->grain);
        $res->wood = max(self::BASE_RESOURCE_SPEED, $res->wood);
        $res->iron = max(self::BASE_RESOURCE_SPEED, $res->iron);
        $res->stone = max(self::BASE_RESOURCE_SPEED, $res->stone);
        return $res;
    }

    /**
     * @return Units
     */
    public function getVillageUnits() {
        $units = $this->getUnits()->where(['map_id' => $this->map_id])->one();
        if ($units) {
            return $units;
        }
        $units = new Units();
        $units->village_id = $this->id;
        $units->map_id = $this->map_id;
        return $units;
    }
}

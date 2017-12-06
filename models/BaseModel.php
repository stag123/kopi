<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\Expression;


class BaseModel extends \yii\db\ActiveRecord {

    public static $behaviors = [];

    public function behaviors()
    {
        $behaviors = static::$behaviors;

        if ($this->hasAttribute('created_at') || $this->hasAttribute('updated_at')) {
            $behaviors[] = [
                'createdAtAttribute' => $this->hasAttribute('created_at') ? 'created_at': false,
                'updatedAtAttribute' => $this->hasAttribute('updated_at') ? 'updated_at': false,
                'class' => TimestampBehavior::className(),
                'value' => new Expression('NOW()')
            ];
        }

        return $behaviors;
    }

    public static function GetActiveList($filter = [], $order = array(), $limit = false){
        $query = self::find()->where($filter)->orderBy($order)->active()->sort();
        $limit && $query->limit($limit);

        return $query->all();
    }

    public static function GetActive($filter = []){
        return self::find()->where($filter)->active()->one();
    }

    public static function GetByCode($code){
        return self::GetActive(['code' => $code]);
    }

    public static function GetByID($id){
        return self::GetActive(['id' => (int)$id]);
    }

    public static function GetArray($filter = [], $key = 'id', $value = false){
        $result = [];
        $data = self::GetActiveList($filter);
        foreach($data as $row) {
            $result[$row->$key] = $value ? $row->$value : $row;
        }
        return $result;
    }

    public static function GetOrCreate($where) {
        $model = self::find()->where($where)->one();
        if (!$model) {
            $model = new static();
            $model->loadDefaultValues();
            $model->setAttributes($where);
            if (!$model->save()) {
                die(serialize($model->getErrors()));
                return false;
            }
        }
        return $model;
    }

    public function GetOrCreateByCode() {
        $where = ['code' => $this->code];
        $model = self::find()->where($where)->one();
        if ($model) {
            return $model;
        }
        if ($this->save()) {
            return $this;
        }
        return false;
    }

    public static function find()
    {
        return new BaseQuery(get_called_class());
    }
}
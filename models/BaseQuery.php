<?php
namespace app\models;

class BaseQuery extends \yii\db\ActiveQuery
{
    private static $cacheModels = [];

    public function getModel() {
        if (!isset(self::$cacheModels[$this->modelClass])) {
            self::$cacheModels[$this->modelClass] = new $this->modelClass;
        }
        return self::$cacheModels[$this->modelClass];
    }

    public function active($boolean = 1)
    {
        if ($this->getModel()->hasAttribute('is_active')) {
            $this->andWhere(['is_active'  => $boolean]);
        }
        if ($this->getModel()->hasAttribute('active_from')) {
            $this->andWhere('active_from <= NOW() OR active_from IS NULL');
        }
        if ($this->getModel()->hasAttribute('active_to')) {
            $this->andWhere('active_to <= NOW() OR active_to IS NULL');
        }

        return $this;
    }

    public function sort($order = SORT_ASC) {
        if ($this->getModel()->hasAttribute('sort')) {
            $this->addOrderBy(['sort' => $order]);
        }
        return $this;
    }

    public function id() {
        return $this->asArray(true)->select('id')->one();
    }

    public function ids() {
        return $this->asArray(true)->select('id')->all();
    }
}
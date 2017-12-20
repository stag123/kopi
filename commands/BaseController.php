<?php
namespace app\commands;

use app\components\InjectionAwareInterface;
use yii\console\Controller;

class BaseController extends Controller implements InjectionAwareInterface
{
    public function __get($name) {
        if (\Yii::$app->has($name)) {
            return \Yii::$app->get($name);
        }
        return parent::__get($name);
    }
}

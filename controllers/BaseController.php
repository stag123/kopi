<?php

namespace app\controllers;

use app\components\InjectionAwareInterface;
use yii\web\Controller;


class BaseController extends Controller implements InjectionAwareInterface
{
    public $ajaxData = [];
    public $initials = [];

    public function __get($name) {
        if (\Yii::$app->has($name)) {
            return \Yii::$app->get($name);
        }
        return parent::__get($name);
    }

    public function beforeAction($action)
    {
        if ($data = $this->request->get('r')) {
            $this->ajaxData = json_decode(urldecode($data), true);
        } else {
            $this->ajaxData = json_decode($this->request->getRawBody(), true);
        }
        return parent::beforeAction($action);
    }

    public function render($view, $params = [])
    {
        $this->view->params['initials'] = json_encode($this->initials);
        return parent::render($view, $params);
    }
}
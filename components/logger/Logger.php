<?php

namespace app\components\logger;
use app\components\BaseComponent;

class Logger {
    public function info($message) {
        \Yii::info($message);
    }
}
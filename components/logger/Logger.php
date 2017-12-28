<?php

namespace app\components\logger;
use app\components\BaseComponent;

class Logger {
    public function info($message) {
        \Yii::info($message);
        echo $message . "\n";
    }

    public function error($message) {
        \Yii::error($message);
        echo $message . "\n";
    }
}
<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ErrorAsset extends BaseAsset
{
    public $js = [
        'bundle/site.page.js'
    ];

    public $css = [
        'js/pages/less/site.css'
    ];

    public $depends = [
        'app\assets\BaseAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}

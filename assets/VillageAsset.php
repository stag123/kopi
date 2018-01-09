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
class VillageAsset extends AssetBundle
{
    public $js = [
        'bundle/village.page.js'
    ];

    public $css = [
        'js/pages/less/village.css'
    ];
    public $depends = [
        'app\assets\BaseAsset'
    ];
}

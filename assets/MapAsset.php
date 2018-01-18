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
class MapAsset extends BaseAsset
{
    public $js = [
        'bundle/map.page.js'
    ];

    public $css = [
        'js/pages/less/map.css'
    ];

    public $depends = [
        'app\assets\BaseAsset'
    ];
}

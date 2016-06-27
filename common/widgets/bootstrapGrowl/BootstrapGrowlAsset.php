<?php
/**
 * AssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace common\widgets\BootstrapGrowl;

use yii\web\AssetBundle;
/**
 * Class AssetBundle
 * @package rmrevin\yii\fontawesome
 */
class BootstrapGrowlAsset extends AssetBundle
{
    /**
     * @inherit
     */
    public $sourcePath = '@bower/bootstrap.growl';

    /**
     * @inherit
     */
    public $css = [

    ];

    public $js = [
        'dist/bootstrap-notify.min.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
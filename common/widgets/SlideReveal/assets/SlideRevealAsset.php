<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 28.04.2016
 * Time: 13:46
 */

namespace common\widgets\SlideReveal\assets;

use yii\web\AssetBundle;

class SlideRevealAsset extends AssetBundle
{

    public $sourcePath = '@bower/slidereveal';

    public $js = [
        'dist/jquery.slidereveal.min.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
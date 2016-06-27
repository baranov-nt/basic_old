<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 28.04.2016
 * Time: 16:09
 */

namespace common\widgets\SlideReveal\assets;

use yii\web\AssetBundle;

class SlideRevealWidgetAsset extends AssetBundle
{
    public $sourcePath = '@common/widgets/SlideReveal';
    public $css = [
        'css/slide-reveal.css'
    ];
    public $depends = [
        'common\widgets\SlideReveal\assets\SlideRevealAsset',
    ];
}
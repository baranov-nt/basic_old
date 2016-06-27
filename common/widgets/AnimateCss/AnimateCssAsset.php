<?php
/**
 * AssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace common\widgets\AnimateCss;

/**
 * Class AssetBundle
 * @package rmrevin\yii\fontawesome
 */
class AnimateCssAsset extends \yii\web\AssetBundle
{
    /**
     * @inherit
     */
    public $sourcePath = '@bower/animate.css';

    /**
     * @inherit
     */
    public $css = [
        'animate.css',
    ];

    public function init()
    {
        parent::init();
    }
}
<?php
/**
 * AssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace common\widgets\BootstrapSelect;

use yii\web\AssetBundle;

/**
 * Class AssetBundle
 * @package rmrevin\yii\fontawesome
 */
class BootstrapSelectAsset extends AssetBundle
{
    /**
     * @inherit
     */
    public $sourcePath = '@bower/bootstrap-select';

    /**
     * @inherit
     */
    public $css = [
        'dist/css/bootstrap-select.min.css',
    ];

    /**
     * @inherit
     */
    public $js = [
        'dist/js/bootstrap-select.min.js',
    ];

    public function init()
    {
        switch (\Yii::$app->language) {
            case 'ru':
                $this->js[] = [
                    'dist/js/i18n/defaults-ru_RU.min.js',
                ];
                break;
            case 'fr':
                $this->js[] = [
                    'dist/js/i18n/defaults-fr_FR.min.js',
                ];
                break;
            case 'de':
                $this->js[] = [
                    'dist/js/i18n/defaults-de_DE.min.js',
                ];
                break;
        }

        if(\Yii::$app->language == 'ru') {

        }

        $this->registerJs();
        parent::init();
    }

    protected function registerJs()
    {
        $js = <<<SCRIPT
            $('.selectpicker').selectpicker({
                  
            });
SCRIPT;
        \Yii::$app->view->registerJs($js);
        return $this;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 30.04.2016
 * Time: 14:17
 */
/* @var $model \common\models\NoticeServiceSearch */
/* @var $key integer */
/* @var $url integer */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;
use yii\helpers\Url;
use common\widgets\AnimateCss\AnimateCssAsset;

AnimateCssAsset::register($this);
Pjax::begin([
    'id' => 'noticeMessageSeen-'.$key
])
?>
<?php
echo \common\widgets\BootstrapGrowl\BootstrapGrowlWidget::widget();
$form = ActiveForm::begin([
    'id' => 'noticeMessageSeenForm-'.$key,
    'options' => ['data-pjax' => true]
]);
?>
<?= $form->field($model, 'seen', ['checkboxTemplate' => '{input}'])
    ->checkbox([ 'onclick' => '
        $.pjax({
            type: "POST",
            url: "'.Url::to(['update-notice-service', 'id' => $key]).'",
            data: jQuery("#noticeMessageSeenForm-'.$key.'").serialize(),
            container: "#noticeMessageSeen-'.$key.'",
            push: false,
            scrollTo: false
        })
    '])->label(false); ?>
<?php
ActiveForm::end();
Pjax::end();
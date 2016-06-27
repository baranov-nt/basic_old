<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 29.04.2016
 * Time: 13:10
 */
/* @var $this \yii\base\View */
/* @var $widget \common\widgets\SlideReveal\SlideRevealWidget */
/* @var $modelNoticeServiceForm \common\widgets\SlideReveal\models\NoticeServiceForm */
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use common\widgets\BootstrapGrowl\BootstrapGrowlWidget;
use common\widgets\BootstrapSelect\BootstrapSelectAsset;
?>

<?= BootstrapGrowlWidget::widget() ?>
<p style="font-size: 10px;">"<strong><?= Html::encode($message) ?></strong>"</p>
<?php
$form = ActiveForm::begin(['action' => Url::to(['/notice/service-notice']), 'options' => ['data-pjax' => true]]);
?>
<?= $form->field($modelNoticeServiceForm, 'status')->dropDownList($modelNoticeServiceForm->statusList, [
    'class'  => 'form-control selectpicker show-tick',
    'data' => [
        'style' => 'btn-info',
    ],
])->label(false) ?>
<?= $form->field($modelNoticeServiceForm, 'message')->textarea(['row' => '2']) ?>
<?= Html::submitButton(Yii::t('app', 'Send the message'), ['class' => 'btn btn-sm btn-success', 'style' => 'margin-right: 10px;']) ?>
<?= Html::button(Yii::t('app', 'Close'), ['class' => 'btn btn-sm btn-warning', 'onclick' => "$('#serviceNoticeBlock').slideReveal('hide')"]) ?>
<?php ActiveForm::end(); ?>



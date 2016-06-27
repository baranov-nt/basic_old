<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 29.04.2016
 * Time: 12:56
 */
/* @var $this \yii\base\View */
/* @var $widget \common\widgets\SlideReveal\SlideRevealWidget */
/* @var $modelNoticeServiceForm \common\widgets\SlideReveal\models\NoticeServiceForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\widgets\Pjax;use common\widgets\BootstrapGrowl\BootstrapGrowlWidget;
?>
<div id="<?= $widget->idBlock ?>" class="hidden-xs visible-sm visible-md visible-lg slide-reveal-main-block" style="background-color: #ffffff;">
    <div id="<?= $widget->idButton ?>" class="<?= $widget->classButton ?>"><span class="<?= $widget->iconButton ?>"></span></div>
    <h3 style="color: #ffffff; padding: 20px 20px 20px 20px; margin: 0 !important; background-color: #337ab7;"><?= $widget->header ?><br>
        <?php
        if ($widget->autoEscape == true):
            ?>
            <small style="color: #ffffff;"><span class="glyphicon glyphicon-info-sign"></span> <?= Yii::t('app', 'Press') ?> <kbd>ESC</kbd> <?= Yii::t('app', 'to close') ?></small>
            <?php
        endif;
        ?>
    </h3>
    <div style="padding: 20px; border: 1px solid #337ab7; height: 100%">
        <?php
        Pjax::begin([
            'id' => 'setviceNoticePjax',
            'enablePushState' => false,
            'timeout' => 9000
        ]);
        ?>
        <?php
        $form = ActiveForm::begin(['action' => Url::to(['/notice/service-notice']), 'options' => ['data-pjax' => true]]);
        ?>
        <?= $form->field($modelNoticeServiceForm, 'status')->dropDownList($modelNoticeServiceForm->statusList, [
            'class'  => 'form-control selectpicker show-tick',
            'data' => [
                'style' => 'btn-sm btn-info',
            ],
        ])->label(false) ?>
        <?= $form->field($modelNoticeServiceForm, 'message')->textarea(['rows' => '2']) ?>
        <?= Html::submitButton(Yii::t('app', 'Send the message'), ['class' => 'btn btn-sm btn-success', 'style' => 'margin-right: 10px;']) ?>
        <?= Html::button(Yii::t('app', 'Close'), ['class' => 'btn btn-sm btn-warning', 'onclick' => "$('#".$widget->idBlock."').slideReveal('hide')"]) ?>
        <?php ActiveForm::end(); ?>
        <?php
        Pjax::end();
        ?>
    </div>
</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $modelImagesExample \common\models\ImagesExample */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="container">
    <div class="materials-form">
        <?php
        Pjax::begin([
            'enablePushState' => false,
            'timeout' => 10000
        ]);
        ?>
        <? $form = ActiveForm::begin([
            'options' => [
                'enctype' => 'multipart/form-data',
                'data-pjax' => true
            ]]);
        ?>
        <?
        echo $form->field($modelImagesExample, 'imageFiles[]')->widget(\kartik\file\FileInput::className(), [
            'language' => 'ru',
            'pluginOptions' => [
                'showCaption' => false,
                'showRemove' => false,
                'showUpload' => true,
                'browseClass' => 'btn btn-success',
            ],
            'options' => [
                'multiple' => true,
                'accept' => 'image/*',
            ]
        ]);
        ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Show uploaded images'), ['class' => 'btn btn-xs btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
        <?php
        Pjax::end();
        ?>
    </div>
</div>
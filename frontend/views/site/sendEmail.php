<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $modelSendEmailForm frontend\models\SendEmailForm */
/* @var $form ActiveForm */
?>
<div class="container">
    <div class="main-sendEmail">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($modelSendEmailForm, 'email') ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Send email'), ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>

    </div>
</div>
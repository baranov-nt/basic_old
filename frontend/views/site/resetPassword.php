<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $modelResetPasswordForm frontend\models\ResetPasswordForm */
/* @var $form ActiveForm */
?>
<div class="container">
    <div class="main-resetPassword">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($modelResetPasswordForm, 'password')->passwordInput() ?>

        <?= $form->field($modelResetPasswordForm, 'password_repeat')->passwordInput() ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Change password'), ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>

    </div>
</div>

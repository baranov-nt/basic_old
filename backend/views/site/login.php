<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\authclient\widgets\AuthChoice;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\LoginForm  */
/* @var $form ActiveForm */
$this->title = Yii::t('app', 'Login');
?>
<div class="main-login">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
    </div>
    <?php $form = ActiveForm::begin([
        'id' => 'loginForm'
    ]); ?>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <?= $form->field($model, 'username') ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Login'), ['class' => 'btn btn-success', 'name' => 'loginButton']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>


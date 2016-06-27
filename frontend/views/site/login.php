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
<div class="container">
    <div class="main-login">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <h1><?= Html::encode($this->title) ?></h1>
                <p><?= Yii::t('app', 'Please fill out the following fields to login:') ?></p>
            </div>
        </div>
        <?php $form = ActiveForm::begin([
            'id' => 'loginForm'
        ]); ?>
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <?= $form->field($model, 'username') ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= $form->field($model, 'rememberMe')->checkbox() ?>
                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app', 'Login'), ['class' => 'btn btn-success', 'name' => 'loginButton']) ?>
                    <?= Html::a(Yii::t('app', 'Registration'), Url::to(['/site/signup']), ['class' => 'btn btn-primary']) ?>
                </div>
                <?= Html::a(Yii::t('app', 'Forgot your password?'), ['/site/send-email']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
        <div class="row" style="margin-top: 20px;">
            <div class="col-md-4 col-md-offset-4">
                <label class="control-label" for="loginform-email"><?= Yii::t('app', 'Login with social network.') ?></label>
                <?php $authAuthChoice = AuthChoice::begin([
                    'baseAuthUrl' => ['auth/index'],
                ]); ?>
                <?php foreach ($authAuthChoice->getClients() as $client): ?>
                    <?php if($client->id == 'yandex'): ?>
                        <?php if(Yii::$app->language == 'ru'): ?>
                            <div style="width: 40px; float: left; font-size: 0;"><?php $authAuthChoice->clientLink($client) ?></div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div style="width: 40px; float: left; font-size: 0;"><?php $authAuthChoice->clientLink($client) ?></div>
                    <?php endif; ?>
                <?php endforeach; ?>
                <?php AuthChoice::end(); ?>
            </div>
        </div>
    </div>
</div>
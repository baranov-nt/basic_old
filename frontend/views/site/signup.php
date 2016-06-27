<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;
use yii\authclient\widgets\AuthChoice;
use yii\helpers\Url;
use common\widgets\BootstrapSelect\BootstrapSelectAsset;

/* @var $this yii\web\View */
/* @var $modelSignupForm frontend\models\SignupForm */
/* @var $modelSignupFormUser common\models\User */
/* @var $form ActiveForm */
$this->title = Yii::t('app', 'Registration');
?>
<div class="container">
    <div class="main-reg">
        <div class="col-md-6 col-md-offset-3">
            <?php
            Pjax::begin([
                'id' => 'signupPjaxBlock',
                'enablePushState' => false,
            ]);
            BootstrapSelectAsset::register($this);
            $form = ActiveForm::begin(['action' => Url::to(['/site/signup']), 'id' => 'signupForm', 'options' => ['data-pjax' => true]]); ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <?php
                            if (!$modelSignupForm->country_iso) {
                                $geo = new \jisoft\sypexgeo\Sypexgeo();
                                $geo->get();
                                $modelSignupForm->country_iso = $geo->country['iso'];
                            }
                            ?>
                            <?= $form->field($modelSignupForm, 'country_iso')->dropDownList($modelSignupForm->countriesList, [
                                'class'  => 'form-control selectpicker',
                                'data' => [
                                    'style' => 'btn-primary',
                                    'live-search' => 'true',
                                    'size' => 10,
                                ],
                                'onchange' => '
                                    $.pjax({
                                        type: "POST",
                                        url: "'.Url::to(['/site/update-phone']).'",
                                        data: jQuery("#signupForm").serialize(),
                                        container: "#signupPjaxBlock",
                                        push: false,
                                        scrollTo: false
                                    })'
                            ])
                            ?>
                        </div>
                        <div class="col-md-6">
                            <?php if($modelSignupForm->country_iso): ?>
                                <?= $form->field($modelSignupForm, 'phone',
                                    [
                                        'inputTemplate' => '<div class="input-group"><span class="input-group-addon">+'.$modelSignupForm->callingCode.'</span>{input}</div>',
                                    ])
                                    ->textInput(
                                        [
                                            'class' => 'form-control',
                                            'maxlength' => $modelSignupForm->phoneNumberDigitsCode ? $modelSignupForm->phoneNumberDigitsCode : 12
                                        ])
                                    ->hint(Yii::t('app', 'Enter the {numbers} digits of phone number.',
                                        [
                                            'numbers' => $modelSignupForm->phoneNumberDigitsCode ? $modelSignupForm->phoneNumberDigitsCode : '5-12'
                                        ])) ?>
                                <?php
                            else:
                                ?>
                                <?= $form->field($modelSignupForm, 'phone',
                                [
                                    'inputTemplate' => '<div class="input-group"><span class="input-group-addon">-</span>{input}</div>',
                                ])->textInput(['class' => 'form-control disabled', 'disabled' => true]) ?>
                                <?php
                            endif;
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 offset6">
                            <?= $form->field($modelSignupForm, 'email') ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($modelSignupForm, 'password')->passwordInput() ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($modelSignupForm, 'password_repeat')->passwordInput() ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('app', 'Registration'), ['class' => 'btn btn-success', 'name' => 'singupButton']) ?>
                        <?= Html::a(Yii::t('app', 'Login'), Url::to(['/site/login']), ['class' => 'btn btn-primary']) ?>
                    </div>
                    <?php
                    if($modelSignupForm->scenario === 'emailActivation'):
                        ?>
                        <i> <?= Yii::t('app', '*We will send you an email with account activation link.') ?> </i>
                        <?php
                    endif;
                    ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
            <?php Pjax::end(); ?>
        </div>
        <div class="col-md-6 col-md-offset-3" style="margin-top: 20px;">
            <label class="control-label" for="loginform-email"><?= Yii::t('app', 'Login with social network.') ?></label>
            <?php $authAuthChoice = AuthChoice::begin([
                'baseAuthUrl' => ['auth/index'],
            ]); ?>
            <?php foreach ($authAuthChoice->getClients() as $client): ?>
                <div style="width: 40px; float: left; font-size: 0;"><?php $authAuthChoice->clientLink($client) ?></div>
            <?php endforeach; ?>
            <?php AuthChoice::end(); ?>
        </div>
    </div>
</div>
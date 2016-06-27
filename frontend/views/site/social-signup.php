<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 20.05.2016
 * Time: 9:34
 */
/* @var $modelUser \common\models\User */
/* @var $modelSignupForm \frontend\models\SignupForm */
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use common\widgets\BootstrapSelect\BootstrapSelectAsset;
use yii\helpers\Html;
use yii\widgets\Pjax;
?>
<div class="container">
    <div class="site-social-signup">
        <div class="col-md-6 col-md-offset-3">
            <?php
            Pjax::begin([
                'id' => 'signupPjaxBlock',
                'enablePushState' => false,
            ]);
            BootstrapSelectAsset::register($this);
            $form = ActiveForm::begin(['action' => Url::to(['/site/social-signup', 'id' => $modelUser->id]), 'id' => 'signupForm', 'options' => ['data-pjax' => true]]); ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($modelSignupForm, 'country_id')->dropDownList($modelSignupForm->countriesList, [
                                'class'  => 'form-control selectpicker',
                                'data' => [
                                    'style' => 'btn-primary',
                                    'live-search' => 'true',
                                    'size' => 10,
                                ],
                                'prompt' => Yii::t('app', 'Select country'),
                                'onchange' => '
                                    $.pjax({
                                        type: "POST",
                                        url: "'.Url::to(['/site/update-phone', 'id' => $modelUser->id]).'",
                                        data: jQuery("#signupForm").serialize(),
                                        container: "#signupPjaxBlock",
                                        push: false,
                                        scrollTo: false
                                    })'
                            ])
                            ?>
                        </div>
                        <div class="col-md-6">
                            <?php if($modelSignupForm->country_id): ?>
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
                    <?php
                    if ($modelUser->email === null):
                        ?>
                        <div class="row">
                            <div class="col-md-6 offset6">
                                <?= $form->field($modelSignupForm, 'email') ?>
                            </div>
                        </div>
                        <?php
                    else:
                        ?>
                        <?= $form->field($modelSignupForm, 'email',
                        [
                            'inputTemplate' => '{input}',
                        ])->textInput(['class' => 'form-control disabled', 'value' => $modelUser->email, 'disabled' => true]) ?>
                        <?= $form->field($modelSignupForm, 'email')->hiddenInput(['value' => $modelUser->email])->hint(false)->label(false) ?>
                        <?php
                    endif;
                    ?>
                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('app', 'Registration'), ['class' => 'btn btn-success', 'name' => 'singupButton']) ?>
                    </div>
                    <?php
                    if($modelSignupForm->scenario === 'emailSocialActivation'):
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
    </div>
</div>

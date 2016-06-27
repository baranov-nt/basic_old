<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\widgets\BootstrapSelect\BootstrapSelectAsset;
/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */

BootstrapSelectAsset::register($this);
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'balance')->textInput() ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'status')->dropDownList($model->statusList,
                [
                    'class'  => 'form-control selectpicker',
                    'data' => [
                        'style' => 'btn-primary',
                    ]
                ]) ?>
        </div>
        <div class="col-md-12">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
                ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

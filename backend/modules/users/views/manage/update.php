<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'User',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->email.' ('.$model->phone.')', 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="user-update">

    <h1><?= Html::encode($this->title).' <span style="color: #337ab7;">'. $model->email.' ('.$model->phone.') </span>' ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

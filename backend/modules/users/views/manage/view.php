<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->email.' ('.$model->phone.')';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'phone',
            'email:email',
            'balance',
            [
                'attribute' => 'status',
                'value' => $model->statusName,
            ],
            [
                'attribute' => 'country_id',
                'value' => $model->countryName,
            ],
            'created_at:date',
            'updated_at:date',
        ],
    ]) ?>

</div>

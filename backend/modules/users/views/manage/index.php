<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\widgets\BootstrapSelect\BootstrapSelectAsset;
/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin([
        'id' => 'usersList',
        'timeout' => false
    ]);
    BootstrapSelectAsset::register($this);
    ?>
    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'tableOptions'=>['class'=>'table-striped table-bordered table-condensed'],
            'columns' => [
                'id',
                [
                    'label' => Yii::t('app', 'Name'),
                    'value' => function ($data) {
                        return $data->userProfile->first_name;
                    },
                ],
                'phone',
                [
                    'attribute' => 'status',
                    'filter' => $searchModel->statusList,
                    'filterInputOptions' => [
                        'class'       => 'form-control selectpicker',
                        'data' => [
                            'style' => 'btn-primary',
                            'size' => 10,
                        ]
                    ],
                    'value' => function ($data) {
                        return $data->statusName;
                    },
                    'contentOptions' => ['style' => 'width:170px;  min-width:170px;  '],
                ],
                [
                    'attribute'=>'item_name',
                    'filter' => $searchModel->rolesList,
                    'filterInputOptions' => [
                        'class'       => 'form-control selectpicker',
                        'data' => [
                            'style' => 'btn-primary',
                            'size' => 10,
                        ]
                    ],
                    'value' =>  function($data) {
                        return $data->roleName;
                    },
                    'contentOptions' => ['style' => 'width:170px;  min-width:170px;  '],
                ],
                [
                    'attribute' => 'country_id',
                    'filter' => $searchModel->countriesList,
                    'filterInputOptions' => [
                        'class'       => 'form-control selectpicker',
                        'data' => [
                            'style' => 'btn-primary',
                            'size' => 10,
                        ]
                    ],
                    'value' => function ($data) {
                        return $data->countryName;
                    },
                    'contentOptions' => ['style' => 'width:170px;  min-width:170px;  '],
                ],
                'email:email',
                [
                    'attribute' => 'balance',
                    'value' => function ($data) {
                        return $data->balance.' '.$data->country->currency;
                    },
                    'contentOptions' => ['style' => 'width:100px;  min-width:100px;  '],
                ],
                'created_at:date',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view}{update}',
                ],
            ],
        ]); ?>
    </div>
    <?php Pjax::end(); ?>
</div>

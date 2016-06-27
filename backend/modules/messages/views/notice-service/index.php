<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use common\widgets\BootstrapSelect\BootstrapSelectAsset;
/* @var $this yii\web\View */
/* @var $searchModel common\models\NoticeServiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = Yii::t('app', 'Service message');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notice-service-index">
    <h1><?= Html::encode($this->title) ?></h1>
<?php
Pjax::begin();
BootstrapSelectAsset::register($this);
?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => [
            'class' => 'table table-striped table-bordered',
        ],
        'emptyCell' => '-',
        'columns' => [
            [
                'attribute' => 'message',
                'format' => 'html',
                'headerOptions' => [
                    //'style' => 'display: block;  width:300px;'
                ],
                'contentOptions' => [
                    //'style' => 'display: block;  width:100%;'
                ],

                'value' => function ($model) {
                    /* @var $model \common\models\NoticeServiceSearch */ 
                    return $model->message;
                },
            ],
            [
                'attribute' => 'user_id',
                'headerOptions' => [
                    'width' => '100',
                ],
                'format' => 'html',
                'filter'=> false,
                'value' => function ($model) {
                    /* @var $model \common\models\NoticeServiceSearch */
                    if (isset($model->user->email)) {
                        return Html::a($model->user->email, Url::to(['/users/manage/view', 'id' => $model->user->id]));
                    } else {
                        return '';
                    }

                },
            ],
            [
                'attribute' => 'status',
                'headerOptions' => [
                    'width' => '100',
                ],
                'filter'=> [ 1 => Yii::t('app', 'Bug'), 0 => Yii::t('app', 'Message')],
                'filterInputOptions' => [
                    'class'       => 'form-control selectpicker show-tick',
                    'data' => [
                        'style' => 'btn-primary',
                        'title' => Yii::t('app', 'Type'),
                    ]
                ],
                'value' => function ($model) {
                    /* @var $model \common\models\NoticeServiceSearch */
                    if($model->status) {
                        return Yii::t('app', 'Bug');
                    } else {
                        return Yii::t('app', 'Message');
                    }
                },
            ],
            [
                'attribute' => 'seen',
                'headerOptions' => [
                    'width' => '100',
                ],
                'format' => 'raw',
                'filter'=> [ 1 => Yii::t('app', 'Seen'), 0 => Yii::t('app', 'Not seen')],
                'filterInputOptions' => [
                    'class'       => 'form-control selectpicker show-tick',
                    'data' => [
                        'style' => 'btn-primary',
                        'title' => Yii::t('app', 'Type'),
                    ]
                ],
                'value' => function ($model, $key, $index, $column) {
                    return $this->render('_seen-content', [
                        'model'     => $model,
                        'key'       => $key,
                        'index'     => $index,
                        'column'    => $column,
                    ]);
                },
            ],
            [
                'attribute' => 'created_at',
                'headerOptions' => [
                    'width' => '120',
                ],
                'value' => function ($model) {
                    /* @var $model \common\models\NoticeServiceSearch */
                    return Yii::$app->formatter->asDate($model->created_at);
                },
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?>
</div>
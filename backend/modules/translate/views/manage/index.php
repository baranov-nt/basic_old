<?php

/**
 * @var View $this
 * @var $searchModel \backend\modules\translate\models\SourceMessageSearch
 * @var $dataProvider yii\data\ActiveDataProvider
 */

use yii\grid\GridView;
use yii\grid\ActionColumn;
use common\widgets\BootstrapSelect\BootstrapSelectAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = Yii::t('app', 'Translations');
$this->params['breadcrumbs'][] = $this->title;
Pjax::begin([
    'enablePushState' => false,
    'timeout' => 9000
]);
BootstrapSelectAsset::register($this);
?>
<div class="translations-index">
    <h2>
        <?php echo Html::a($this->title, ['/translate/index']); ?>
        <span class="pull-right btn-group">
            <?= Html::a(Yii::t('app', 'Rescan'), Url::to(['/translate/manage/rescan']), ['class' => 'btn btn-success']) ?>
            <?= Html::a(Yii::t('app', 'Clear Cache'), Url::to(['/translate/manage/clear-cache']), ['class' => 'btn btn-warning']) ?>
        </span>
    </h2>
    <?php
    echo GridView::widget([
        'filterModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'columns' => [
            // ----------------------------- ID --------------------------------
            [
                'attribute' => 'id',
                'headerOptions' => [
                    'width' => '50',
                ],
                'contentOptions' => [
                    'class' => 'text-align-center',
                ],
                'value' => function ($model/*, $key, $index, $dataColumn*/) {
                    return $model->id;
                },
                'filter' => false,
                'visible' => true,
            ],
            [
                'attribute' => 'message',
                'format' => 'raw',
                'headerOptions' => [
                    'width' => '100',
                ],
                'contentOptions' => [
                    'class' => 'source-message',
                ],
                'value' => function ($model, $key, $index, $column) {
                    return $this->render('_source-message-content', [
                        'model'     => $model,
                        'key'       => $key,
                        'index'     => $index,
                        'column'    => $column,
                    ]);
                },
            ],
            [
                'attribute' => 'translation',
                'label' => Yii::t('app', 'Translations'),
                'contentOptions' => [
                    'class' => 'translation-tabs tabs-mini',
                ],
                'value' => function ($model, $key, $index, $column) {
                    return $this->render('_message-tabs', [
                        'model'     => $model,
                        'key'       => $key,
                        'index'     => $index,
                        'column'    => $column,
                    ]);
                },
                'format' => 'raw',
            ],
            // --------------------------- CATEGORY ----------------------------
            [
                'attribute' => 'category',
                'headerOptions' => [
                    'width' => '100',
                ],
                'contentOptions' => [
                    'class' => 'text-align-center',
                ],
                'value' => function ($model/*, $key, $index, $dataColumn*/) {
                    return $model->category;
                },
                'filter' => $searchModel::getCategories(),
                'filterInputOptions' => [
                    'class'       => 'form-control selectpicker show-tick',
                    'data' => [
                        'style' => 'btn-primary',
                        'title' => Yii::t('app', 'Category'),
                    ]
                ],
            ],
            [
                'class' => ActionColumn::className(),
                'template' => '{save}',
                'headerOptions' => [
                    'width' => '40',
                ],
                'buttons' => [
                    'save' => function ($url, $model, $key) {
                        return Html::button('<span class="glyphicon glyphicon-save">', [
                            'class' => 'btn btn-sm btn-success',
                            'onclick' => '
                                $.pjax({
                                    type: "POST",
                                    url: "'.$url.'",
                                    data: jQuery("#translationsForm-'.$key.'").serialize(),
                                    container: "#translationGrid-'.$key.'",
                                    push: false,
                                    scrollTo: false
                                })
                            '
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>
</div>
<?php
Pjax::end();

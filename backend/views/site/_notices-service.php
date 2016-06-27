<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 30.04.2016
 * Time: 9:03
 */
/* @var $modelStatistics \backend\models\Statistics */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
?>
<div class="col-md-12">
    <h3><?= Html::a(Yii::t('app', 'Service message'), Url::to(['/messages/notice-service/index'])) ?></h3>
    <?= DetailView::widget([
        'model' => $modelStatistics,
        'attributes' => [
            [
                'attribute' => 'numberOfAllNotitesService',
                'value' => $modelStatistics->countAllNotitesService,
            ],
            [
                'label' => Html::a($modelStatistics->getAttributeLabel('numberOfNewNotitesService'), Url::to(['/messages/notice-service/index', 'NoticeServiceSearch[seen]' => 0])),
                'format' => 'html',
                'value' => '<span style="color: red;">+'.$modelStatistics->countNewNotitesService.'</span>',
            ],
            [
                'attribute' => 'numberOfReportsBug',
                'value' => $modelStatistics->countReportsBug,
            ],
            [
                'attribute' => 'numberOfReportsAdmin',
                'value' => $modelStatistics->countReportsAdmin,
            ],
        ],
    ]);
    ?>
</div>

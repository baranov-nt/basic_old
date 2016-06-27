<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 30.04.2016
 * Time: 8:55
 */
/* @var $modelStatistics \backend\models\Statistics */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
?>
<div class="col-md-12">
    <h3><?= Html::a(Yii::t('app', 'Users'), Url::to(['/users/manage/index'])) ?></h3>
    <?= DetailView::widget([
        'model' => $modelStatistics,
        'attributes' => [
            [
                'attribute' => 'numberOfUsers',
                'value' => $modelStatistics->countUsers,
            ],
            [
                'attribute' => 'numberOfActiveUsers',
                'value' => $modelStatistics->countActiveUsers,
            ],
            [
                'attribute' => 'numberOfNotActiveUsers',
                'value' => $modelStatistics->countNotActiveUsers,
            ],
            [
                'attribute' => 'numberOfDeletedUsers',
                'value' => $modelStatistics->countDeletedUsers,
            ],
        ],
    ]);
    ?>
</div>

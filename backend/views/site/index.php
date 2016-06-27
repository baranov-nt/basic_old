<?php
use yii\bootstrap\Collapse;
/* @var $this yii\web\View */
/* @var $modelStatistics \backend\models\Statistics */

$this->title = Yii::t('app', 'Statistics of application');
?>
<div class="site-index">
    <h1><?= $this->title ?></h1>
    <div class="row">
        <?php
        echo Collapse::widget([
            'items' => [
                [
                    'label' => Yii::t('app', 'Users').' - '.$modelStatistics->countUsers,
                    'content' => $this->render('_users', ['modelStatistics' => $modelStatistics]),
                    'contentOptions' => [
                    ],
                    'options' => [
                        'class' => 'in'
                    ],
                ],
                [
                    'label' => Yii::t('app', 'Service message').' - '.$modelStatistics->countAllNotitesService.' <span style="color: red;">(+'.$modelStatistics->countNewNotitesService.')</span>',
                    'content' => $this->render('_notices-service', ['modelStatistics' => $modelStatistics]),
                    'contentOptions' => [
                    ],
                    'options' => [
                        'class' => 'in'
                    ],
                ],
            ],
            'encodeLabels' => false,
            'options' => [

            ]
        ]);
        ?>
    </div>
</div>

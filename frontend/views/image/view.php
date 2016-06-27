<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 23.05.2016
 * Time: 16:20
 */
/* @var $this yii\web\View */
/* @var $one \common\models\ImagesExample */
/* @var $modelImagesExample array */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use common\widgets\BootstrapGrowl\BootstrapGrowlWidget;
?>
<div class="container">
    <div class="row">
        <?php
        Pjax::begin([
            'enablePushState' => false,
            'timeout' => 10000
        ]);
        ?>
        <?= BootstrapGrowlWidget::widget() ?>
        <?php
        if ($modelImagesExample == null):
            ?>
            <p><?= Yii::t('app', 'No uploaded images.') ?></p>
            <?php
        endif;
        ?>
        <?php
        foreach ($modelImagesExample as $one):
            ?>
            <div class="col-md-2">
                <?= Html::img('/'.$one->image_path, ['style' => 'width: 100%']) ?>
                <?= Html::a(Yii::t('app', 'Delete'), Url::to(['delete', 'id' => $one->id]), ['class' => 'btn btn-xs btn-danger', 'style' => 'margin-top: 10px;']) ?>
            </div>
            <?php
        endforeach;
        ?>
        <div class="col-md-12">
            <?= Html::a(Yii::t('app', 'Load new images'), Url::to(['load-images']), ['class' => 'btn btn-xs btn-primary', 'style' => 'margin-top: 10px;']) ?>
        </div>
        <?php
        Pjax::end();
        ?>
    </div>
</div>

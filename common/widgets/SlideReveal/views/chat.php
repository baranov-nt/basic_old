<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 28.04.2016
 * Time: 15:47
 */
/* @var $this \yii\base\View */
/* @var $widget \common\widgets\SlideReveal\SlideRevealWidget */
use yii\helpers\Html;
?>
<div id="<?= $widget->idBlock ?>" class="hidden-xs visible-sm visible-md visible-lg slide-reveal-main-block" style="background-color: #ffffff;">
    <div id="<?= $widget->idButton ?>" class="<?= $widget->classButton ?>"><span class="<?= $widget->iconButton ?>"></span></div>
    <h3 style="color: #ffffff; padding: 20px 20px 20px 20px; margin: 0 !important; background-color: #337ab7;"><?= $widget->header ?><br>
        <?php
        if ($widget->autoEscape == true):
        ?>
        <small style="color: #ffffff;"><span class="glyphicon glyphicon-info-sign"></span> <?= Yii::t('app', 'Press') ?> <kbd>ESC</kbd> <?= Yii::t('app', 'to close') ?></small>
        <?php
        endif;
        ?>
    </h3>
    <div style="padding: 20px; border: 1px solid #337ab7; height: 100%">
        <?= Html::button(Yii::t('app', 'Close'), ['class' => 'btn btn-warning', 'onclick' => "$('#".$widget->idBlock."').slideReveal('hide')"]) ?>
    </div>
</div>

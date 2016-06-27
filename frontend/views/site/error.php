<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="container">
    <div class="site-error">

        <h1><?= \Yii::t('yii', 'Error') ?></h1>

        <div class="alert alert-danger">
            <?= nl2br(Html::encode($message)) ?>
        </div>
        <div class="col-md-2 col-md-offset-4">
        <div class="tv-image">
            <div class="tv-box">

            </div>
        </div>
        </div>
    </div>
</div>

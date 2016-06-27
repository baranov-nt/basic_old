<?php
use frontend\assets\AppAsset;
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;
use yii\helpers\Html;
use yii\helpers\Url;
use common\widgets\BootstrapGrowl\BootstrapGrowlWidget;
use yii\widgets\Breadcrumbs;

/**
 * Created by PhpStorm.
 * User: phpNT
 * Date: 28.02.2015
 * Time: 1:48
 */
/* @var $content string
 * @var $this \yii\web\View
 * @var $user \common\models\User */
AppAsset::register($this);

$user = Yii::$app->user->identity;
$this->beginPage();
?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>" prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb#">
    <head>
        <?= Html::csrfMetaTags() ?>
        <meta charset="<?= Yii::$app->charset ?>">
        <?php $this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1']); ?>
        <title><?= $this->title ?></title>
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody(); ?>

    <div class="wrap">
        <?php
        NavBar::begin(
            [
                'options' => [
                    'class' => 'navbar navbar-default',
                    'id' => 'main-menu'
                ],
                'renderInnerContainer' => true,
                'innerContainerOptions' => [
                    'class' => 'container'
                ],
                'brandLabel' => Yii::t('app', 'Manage {name} app', ['name' => '<strong>'.Yii::$app->name.'</strong>']),
                'brandUrl' => [
                    '/site/index'
                ],
                'brandOptions' => [
                    'class' => 'navbar-brand'
                ]
            ]
        );

        if (!Yii::$app->user->isGuest):
            $menuItems[] = [
                'label' => Yii::t('app', 'Users messages'),
                'items' => [
                    [
                        'label' => Yii::t('app', 'Service message'),
                        'url' => Url::to(['/messages/notice-service/index']),
                    ]
                ],
                'linkOptions' => [
                    'id' => 'myAccount'
                ]
            ];
            $menuItems[] = [
                'label' => Yii::t('app', 'Translation Manager'),
                'url' => Url::to(['/translate/manage/index'])
            ];
            $menuItems[] = [
                'label' => Yii::t('app', 'Manage Users'),
                'url' => Url::to(['/users/manage/index'])
            ];
            $menuItems[] = [
                'label' => $user->email,
                'items' => [
                    [
                        'label' => Yii::t('app', 'Logout'),
                        'url' => Url::to(['/site/logout']),
                        'linkOptions' => [
                            'id' => 'logoutUser'
                        ]
                    ]
                ],
                'linkOptions' => [
                    'id' => 'myAccount'
                ]
            ];
        else:
            $menuItems[] = [
                'label' => Yii::t('app', 'Login'),
                'url' => Url::to(['/site/login'])
            ];

        endif;

        //$menuItems[] = \common\widgets\LanguageSelect\LanguageSelect::widget();

        echo Nav::widget([
            'items' => $menuItems,
            'activateParents' => true,
            'encodeLabels' => false,
            'options' => [
                'class' => 'navbar-nav navbar-right'
            ]
        ]);
        ?>

        <?php
        NavBar::end();
        ?>
        <?= BootstrapGrowlWidget::widget() ?>
        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer" style="background-color: #337ab7; max-height: 100%; margin-top: 70px !important;">
        <div class="container" >
            <span class="badge badge-primary">
                <span class="glyphicon glyphicon-copyright-mark"></span> <?= Yii::$app->name.' '.date('Y') ?>
            </span>
        </div>
    </footer>

    <?php $this->endBody(); ?>
    </body>
    </html>
<?php
$this->endPage();
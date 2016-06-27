<?php
use frontend\assets\AppAsset;
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use common\widgets\AnimateCss\AnimateCssAsset;
use common\widgets\BootstrapGrowl\BootstrapGrowlWidget;
use common\widgets\FontAwesome\FontAwesomeAsset;
use common\widgets\SlideReveal\SlideRevealWidget;
use common\widgets\LanguageSelect\LanguageSelect;
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
AnimateCssAsset::register($this);
FontAwesomeAsset::register($this);

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
                'brandLabel' => Yii::$app->name,
                'brandUrl' => [
                    '/site/index'
                ],
                'brandOptions' => [
                    'class' => 'navbar-brand'
                ]
            ]
        );

        $menuItems[] = [
            'label' => 'Тестовое задание',
            'url' => Url::to(['/image/load-images'])
        ];

        if (!Yii::$app->user->isGuest):
            $menuItems[] = [
                'label' => $user->email,
                'items' => [
                    '<li class="dropdown-header">'.Yii::t('app', 'My account').'</li>',
                    '<li class="divider"></li>',
                    [
                        'label' => Yii::t('app', 'Profile'),
                        'url' => Url::to(['/user/profile/index'])
                    ],
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
                'label' => Yii::t('app', 'Authorization'),
                'items' => [
                    '<li class="dropdown-header">'.Yii::t('app', 'Authorization').'</li>',
                    '<li class="divider"></li>',
                    [
                        'label' => Yii::t('app', 'Login'),
                        'url' => Url::to(['/site/login'])
                    ],
                    [
                        'label' => Yii::t('app', 'Registration'),
                        'url' => Url::to(['/site/signup'])
                    ]
                ],
                'linkOptions' => [

                ]
            ];

        endif;

        echo LanguageSelect::widget();

        echo Nav::widget([
            'items' => $menuItems,
            'activateParents' => true,
            'encodeLabels' => false,
            'options' => [
                'class' => 'navbar-nav navbar-right'
            ]
        ]);

        Modal::begin(
            [
                'size' => "modal-lg",
                'header' => '<h2>'.Yii::t('app', 'Feed ads').'</h2>',
                'id' => 'modal'
            ]
        );
        echo Yii::t('app', 'Rules');
        Modal::end();
        ?>

        <?php
        NavBar::end();
        ?>
        <?= BootstrapGrowlWidget::widget() ?>
        <?= $content ?>
    </div>

    <?= SlideRevealWidget::widget([
        'header' => Yii::t('app', 'Service message'),
        'idButton' => 'serviceNoticeButton',
        'idBlock' => 'serviceNoticeBlock',
        'classButton' => 'handle-left',
        'iconButton' => 'fa fa-bug fa-2x',
        'width' => '30%',
        'push' => false,
        'overlay' => false,
        'position' => 'left',
        'autoEscape' => true
    ]); ?>

    <footer class="footer" style="background-color: #337ab7; max-height: 100%; margin-top: 70px !important;">
        <div class="container" >
            <span class="badge badge-primary" style="z-index: 1 !important;">
                <i class="fa fa-copyright" aria-hidden="true"></i> <?= Yii::$app->name.' '.date('Y') ?>
            </span>
        </div>
    </footer>

    <?php $this->endBody(); ?>
    </body>
    </html>
<?php
$this->endPage();
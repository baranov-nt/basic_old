<?php
return [
    'name' => 'Basic',
    'language' => 'en',
    'charset' => 'UTF-8',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'ipgeobase' => [
            'class' => 'himiklab\ipgeobase\IpGeoBase',
            //'useLocalDB' => true,
        ],
        'user' => [
            'class' => 'yii\web\User',
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['site/login'],
        ],
        'formatter' => [                                            // выводит данные в заданом формате
            'class' => 'yii\i18n\Formatter',
            'nullDisplay' => '&nbsp;',
            'dateFormat' => 'php:d-m-Y',
            'datetimeFormat' => 'php:d-m-Y H:i a',
            'timeFormat' => 'php:H:i A',
        ],
        'urlManager' => [
            'class' => 'codemix\localeurls\UrlManager',
            'languages' => ['ru', 'en', 'de', 'fr'],
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'rules' => [
                [
                    'pattern' => '',
                    'route' => 'site/index',
                    'suffix' => ''
                ],
                [
                    'pattern' => 'auth/index',
                    'route' => 'auth/index',
                    'suffix' => ''
                ],
                [
                    'pattern' => 'image/get/<id>/<width>/<height>/<type>',
                    'route' => 'image/get',
                ],
                [
                    'pattern' => '<controller>/<action>/<id:\d+>',
                    'route' => '<controller>/<action>',
                    'suffix' => '.html'
                ],
                [
                    'pattern' => '<controller>/<action>/<id:\d+>',
                    'route' => '<controller>/<action>',
                    'suffix' => '.html'
                ],
                [
                    'pattern' => '<controller>/<action>',
                    'route' => '<controller>/<action>',
                    'suffix' => '.html'
                ],
                [
                    'pattern' => '<module>/<controller>/<action>/<id:\d+>',
                    'route' => '<module>/<controller>/<action>',
                    'suffix' => ''
                ],
                [
                    'pattern' => '<module>/<controller>/<action>',
                    'route' => '<module>/<controller>/<action>',
                    'suffix' => ''
                ],
            ]
        ],
        'redis' => [
            'class' => \yii\redis\Connection::className(),
            'hostname' => 'localhost',
            'port' => 6379,
            'database' => 0,
            //'dataTimeout' => 30
        ],
        'cache' => [
            //'class' => 'yii\caching\FileCache',
            'class' => 'yii\redis\Cache',
            'redis' => [
                'hostname' => 'localhost',
                'port' => 6379,
                'database' => 1,
            ],
        ],
        'session' => [
            //'class' => 'yii\web\Session',
            'class' => 'yii\redis\Session',
            'redis' => [
                'hostname' => 'localhost',
                'port' => 6379,
                'database' => 2,
            ],
            //'timeout' => 30,
            //'cookieParams' => ['httponly' => true, 'lifetime' => 3600 * 4],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'authClientCollection' => require(__DIR__ . '/auth.php'), 
        'i18n' => [
            'class'      => \backend\modules\translate\components\I18N::className(),
            'languages' => ['ru', 'de', 'fr'],
            'format'     => 'db',
            'sourcePath' => [
                __DIR__ . '/../../frontend',
                __DIR__ . '/../../backend',
                __DIR__ . '/../../common',
                __DIR__ . '/../../console',
            ],
            'messagePath' => __DIR__  . '/../../messages',
            'translations' => [
                '*' => [
                    'class'           => yii\i18n\DbMessageSource::className(),
                    'enableCaching'   => true,
                    'cachingDuration' => 60 * 60 * 2, // cache on 2 hours
                ],
                'yii' => [
                    'class'           => yii\i18n\DbMessageSource::className(),
                    'enableCaching'   => true,
                    'cachingDuration' => 60 * 60 * 2, // cache on 2 hours
                ],
                'app' => [
                    'class'           => yii\i18n\DbMessageSource::className(),
                    'enableCaching'   => true,
                    'cachingDuration' => 60 * 60 * 2, // cache on 2 hours
                ],
            ],
        ],
        /*'sypexGeo' => [
            'class' => 'omnilight\sypexgeo\SypexGeo',
            'database' => '@common/data/SxGeoCity.dat',
        ],
        'request' => [
            'as sypexGeo' => [
                'class' => 'omnilight\sypexgeo\GeoBehavior',
                // It is not required to define property sypexGeo if you have sypexGeo component defined
                // in your application
                'sypexGeo' => [
                    'database' => '@common/data/SxGeoCity.dat',
                ]
            ]
        ],*/
    ],
];

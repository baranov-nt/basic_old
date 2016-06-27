<?php
/**
 * Created by PhpStorm.
 * User: phpNT
 * Date: 30.06.2015
 * Time: 5:48
 */

namespace backend\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;

class BehaviorsController extends Controller {

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                /*'denyCallback' => function ($rule, $action) {
                    throw new \Exception('Нет доступа.');
                },*/
                'rules' => [
                    [
                        'allow' => true,
                        'controllers' => ['site'],
                        'actions' => ['index'],
                        'roles' => ['Администратор']
                    ],
                    [
                        'allow' => true,
                        'controllers' => ['site'],
                        'actions' => ['login', 'error', 'logout'],
                    ],
                    [
                        'allow' => true,
                        'controllers' => ['users/manage'],
                        'actions' => ['index', 'update', 'view'],
                        'roles' => ['Администратор']
                    ],
                    [
                        'allow' => true,
                        'controllers' => ['translate/manage'],
                        'actions' => ['index', 'rescan', 'clear-cache', 'save'],
                        'roles' => ['Администратор']
                    ],
                    [
                        'allow' => true,
                        'controllers' => ['messages/notice-service'],
                        'actions' => ['index', 'update-notice-service'],
                        'roles' => ['Администратор']
                    ],
                ]
            ],
        ];
    }
}
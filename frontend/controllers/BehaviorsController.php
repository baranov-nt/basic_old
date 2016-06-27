<?php
/**
 * Created by PhpStorm.
 * User: phpNT
 * Date: 30.06.2015
 * Time: 5:48
 */

namespace frontend\controllers;

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
                        'actions' => ['update-phone'],
                        'verbs' => ['GET', 'POST'],
                        'roles' => ['?']
                    ],
                    [
                        'allow' => true,
                        'controllers' => ['site'],
                        'actions' => ['logout'],
                        'roles' => ['@']
                    ],
                    [
                        'allow' => true,
                        'controllers' => ['site'],
                        'actions' => ['login', 'signup', 'index', 'phpinfo', 'error', 'activate-account', 'send-email', 'reset-password', 'social-signup'],
                    ],
                    [
                        'allow' => true,
                        'controllers' => ['user/profile'],
                        'actions' => ['index', 'update'],
                        'roles' => ['@']
                    ],
                    [
                        'allow' => true,
                        'controllers' => ['notice'],
                        /*'actions' => ['index', 'update'],
                        'roles' => ['@']*/
                    ],
                ]
            ],
        ];
    }
}
<?php
namespace backend\controllers;

use yii\web\Controller;
use common\models\LoginForm;
use backend\models\Statistics;

/**
 * Site controller
 */
class SiteController extends BehaviorsController
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        $modelStatistics = new Statistics();
        return $this->render('index',
            [
                'modelStatistics' => $modelStatistics
            ]);
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $modelLoginForm = new LoginForm();
        if ($modelLoginForm->load(\Yii::$app->request->post()) && $modelLoginForm->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $modelLoginForm,
            ]);
        }
    }

    public function actionLogout()
    {
        \Yii::$app->user->logout();

        return $this->goHome();
    }
}

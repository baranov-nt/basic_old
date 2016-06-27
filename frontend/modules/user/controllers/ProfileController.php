<?php

namespace frontend\modules\user\controllers;

use common\models\UserProfile;
use yii\web\NotFoundHttpException;
use frontend\controllers\BehaviorsController;

/**
 * ProfileController implements the CRUD actions for UserProfile model.
 */
class ProfileController extends BehaviorsController
{
    /**
     * Lists all UserProfile models.
     * @return mixed
     */
    public function actionIndex()
    {
        $newUser = \Yii::$app->redis->executeCommand('GET', ['users:signup:'.\Yii::$app->user->id]);
        if($newUser) {
            \Yii::$app->redis->executeCommand('DEL', ['users:signup:'.\Yii::$app->user->id]);
            \Yii::$app->session->setFlash('0',
                [
                    'type'      => 'info',
                    'icon'      => 'fa fa-smile-o',
                    'title'     => '<strong>'.\Yii::t('app', 'Hello').':</strong><br>',
                    'message'   => \Yii::t('app', 'Welcome to {name} app!', ['name' => \Yii::$app->name]),
                ]
            );
        }

        return $this->render('view', [
            'model' => $this->findModel(),
        ]);
    }

    /**
     * Updates an existing UserProfile model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate()
    {
        $model = $this->findModel();

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->user_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Finds the UserProfile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserProfile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel()
    {
        if (($model = UserProfile::findOne(\Yii::$app->user->id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

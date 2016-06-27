<?php

namespace backend\modules\messages\controllers;

use common\models\NoticeService;
use common\models\NoticeServiceSearch;
use backend\controllers\BehaviorsController;
use yii\web\NotFoundHttpException;

/**
 * NoticeServiceController implements the CRUD actions for NoticeService model.
 */
class NoticeServiceController extends BehaviorsController
{
    /**
     * Lists all NoticeService models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NoticeServiceSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Updates an existing NoticeService model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdateNoticeService($id)
    {
        $modelNoticeService = $this->findModel($id);

        if ($modelNoticeService->load(\Yii::$app->request->post()) && $modelNoticeService->save()) {
            \Yii::$app->session->set(
                'message',
                [
                    'type'      => 'info',
                    'icon'      => 'glyphicon glyphicon-envelope',
                    'message'   => \Yii::t('app', 'Message status successfully changed.'),
                ]
            );
        }
        return $this->render('_seen-content', [
            'model' => $modelNoticeService,
            'key' => $id,
        ]);
    }

    /**
     * Finds the NoticeService model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return NoticeService the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = NoticeService::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

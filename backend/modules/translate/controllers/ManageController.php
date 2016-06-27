<?php
/**
 * Created by PhpStorm.
 * User: phpNT
 * Date: 05.12.2015
 * Time: 10:54
 */

namespace backend\modules\translate\controllers;

use backend\modules\translate\models\SourceMessage;
use backend\modules\translate\models\SourceMessageSearch;
use yii\web\NotFoundHttpException;
use backend\controllers\BehaviorsController;


class ManageController extends BehaviorsController
{
    public function actionIndex()
    {
        $searchModel = SourceMessageSearch::getInstance();
        $dataProvider = $searchModel->search(\Yii::$app->getRequest()->get());
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionRescan()
    {
        $result = \backend\modules\translate\models\SourceMessageSearch::getInstance()->extract();
        \Yii::$app->session->set(
            'message',
            [
                'type'      => 'info',
                'message'   => \Yii::t('app', 'New messages:') . ' ' . (isset($result['new']) ? $result['new'] : 0).'<br>'.\Yii::t('app', 'Deleted messages:') . ' ' . (isset($result['deleted']) ? $result['deleted'] : 0)
            ]
        );
        return $this->redirect('index');
    }

    public function actionClearCache()
    {
        \Yii::$app->session->set(
            'message',
            [
                'type'      => 'info',
                'message'   => \Yii::t('app', 'Cache successfully cleared.')
            ]
        );
        \Yii::$app->cache->redis->executeCommand('FLUSHDB');
        return $this->redirect('index');
    }

    public function actionSave($id)
    {
        if (!\Yii::$app->request->isPjax) {
            return $this->redirect(['/translate/manage/index']);
        }
        $modelSourceMessage = \backend\modules\translate\models\SourceMessage::findOne($id);
        $saveTranslation = false;

        if($modelSourceMessage) {
            $saveTranslation = $modelSourceMessage->saveMessages(\Yii::$app->request->post('Messages'));
        }

        if ($saveTranslation) {
            \Yii::$app->cache->redis->executeCommand('FLUSHDB');
            \Yii::$app->session->set(
                'message',
                [
                    'type'      => 'info',
                    'message'   => \Yii::t('app', 'Message successfully saved.')
                ]
            );
        } else {
            \Yii::$app->session->set(
                'message',
                [
                    'type'      => 'danger',
                    'message'   => \Yii::t('app', 'Message successfully saved.')
                ]
            );
        }

        return $this->render('_message-tabs', [
            'model' => $modelSourceMessage,
            'key' => $id,
        ]);
    }

    /**
     * @param array|integer $id
     * @return SourceMessage|SourceMessage[]
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        $query = SourceMessage::find()->where('id = :id', [':id' => $id]);
        $models = is_array($id)
            ? $query->all()
            : $query->one();
        if (!empty($models)) {
            return $models;
        } else {
            throw new NotFoundHttpException(\Yii::t('app', 'The requested page does not exist'));
        }
    }
}

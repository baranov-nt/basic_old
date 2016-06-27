<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 29.04.2016
 * Time: 13:02
 */

namespace frontend\controllers;

use common\widgets\SlideReveal\models\NoticeServiceForm;

class NoticeController extends BehaviorsController
{
    public function actionServiceNotice()
    {
        $modelNoticeServiceForm = new NoticeServiceForm();
        if ($modelNoticeServiceForm->load(\Yii::$app->request->post()) && $modelNoticeServiceForm->validate()) {
            if ($modelNoticeServiceForm->saveMessage()) {
                \Yii::$app->session->set(
                    'message',
                    [
                        'type'      => 'info',
                        'icon'      => 'glyphicon glyphicon-envelope',
                        'message'   => \Yii::t('app', 'Your message was successfully sent.'),
                    ]
                );
                $message = $modelNoticeServiceForm->message;
                $modelNoticeServiceForm = new NoticeServiceForm();
            }
        };
        

        return $this->renderAjax(
            'service-notice',
            [
                'modelNoticeServiceForm' => $modelNoticeServiceForm,
                'message' => $message
            ]
            );
    }
}
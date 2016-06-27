<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 13.01.2016
 * Time: 12:51
 */

namespace frontend\controllers;

use common\models\ImagesExample;
use yii\web\Controller;
use yii\web\UploadedFile;

class ImageController extends Controller
{
    public function actionLoadImages()
    {
        $modelImagesExample = new ImagesExample();
        if ($modelImagesExample->load(\Yii::$app->request->post())) {
            $modelImagesExample->updateImages(UploadedFile::getInstances($modelImagesExample, 'imageFiles'), $id = false);
            $modelImagesExample = ImagesExample::find()->all();
            return $this->render('view', [
                'modelImagesExample' => $modelImagesExample,
            ]);
        }
        return $this->render('_form', [
            'modelImagesExample' => $modelImagesExample,
        ]);
    }

    public function actionView()
    {
        $modelImagesExample = ImagesExample::find()->all();
        return $this->render('view', [
            'modelImagesExample' => $modelImagesExample,
        ]);
    }

    public function actionDelete($id)
    {
        $delete = ImagesExample::findOne($id)->delete();
        if ($delete == true) {
            \Yii::$app->session->set(
                'message',
                [
                    'type'      => 'info',
                    'icon'      => 'glyphicon glyphicon-envelope',
                    'message'   => \Yii::t('app', 'Image has been successfully deleted.'),
                ]
            );
        }
        $modelImagesExample = ImagesExample::find()->all();
        return $this->render('view', [
            'modelImagesExample' => $modelImagesExample,
        ]);
    }
}
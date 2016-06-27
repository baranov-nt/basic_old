<?php

namespace common\models;

use Yii;
use yii\helpers\FileHelper;
use Imagine\Image\Point;

/**
 * This is the model class for table "images_example".
 *
 * @property integer $id
 * @property string $image_path
 */
class ImagesExample extends \yii\db\ActiveRecord
{
    public $imageFiles;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'images_example';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['image_path'], 'required'],
            [['image_path'], 'string', 'max' => 255],
            [['imageFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxFiles' => 5],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image_path' => 'Image Path',
            'imageFiles' => Yii::t('app', 'Load images'),
        ];
    }

    public function updateImages($images, $id)
    {
        ImagesExample::deleteAll();
        $md5_1 = Yii::$app->security->generateRandomString(2);
        $md5_2 = Yii::$app->security->generateRandomString(2);
        $saveMainPath = 'uploads/'.$md5_1.'/'.$md5_2;
        FileHelper::createDirectory($saveMainPath);
        $this->imageFiles = $images;
        $i = 1;
        foreach ($this->imageFiles as $file) {
            $savePath = $saveMainPath.'/'.$i.'_'. $id.'_'.time(). '.' . $file->extension;
            if($file->saveAs($savePath)):
                $modelImagesExample = new ImagesExample();
                $modelImagesExample->image_path = $savePath;
                if($modelImagesExample->save()):
                endif;
            else:
                return false;
            endif;
            $i++;
        }
        return true;
    }
}

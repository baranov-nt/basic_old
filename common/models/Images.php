<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "images".
 *
 * @property integer $id
 * @property string $path_small_image
 * @property string $path
 * @property integer $size
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $temp
 *
 * @property ImagesOfObject[] $imagesOfObjects
 */
class Images extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['path_small_image', 'path'], 'required'],
            [['size', 'status', 'created_at', 'updated_at', 'temp'], 'integer'],
            [['path_small_image', 'path'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app', 'ID'),
            'path_small_image' => \Yii::t('app', 'Path Small Image'),
            'path' => \Yii::t('app', 'Path'),
            'size' => \Yii::t('app', 'Size'),
            'status' => \Yii::t('app', 'Status'),
            'created_at' => \Yii::t('app', 'Created At'),
            'updated_at' => \Yii::t('app', 'Updated At'),
            'temp' => \Yii::t('app', 'Temp'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImagesOfObjects()
    {
        return $this->hasMany(ImagesOfObject::className(), ['image_id' => 'id']);
    }
}

<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "images_of_object".
 *
 * @property integer $id
 * @property integer $image_id
 * @property integer $object_id
 * @property integer $label
 * @property integer $place
 *
 * @property Images $image
 */
class ImagesOfObject extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'images_of_object';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['image_id', 'object_id', 'label', 'place'], 'integer'],
            [['image_id'], 'exist', 'skipOnError' => true, 'targetClass' => Images::className(), 'targetAttribute' => ['image_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app', 'ID'),
            'image_id' => \Yii::t('app', 'Image ID'),
            'object_id' => \Yii::t('app', 'Object ID'),
            'label' => \Yii::t('app', 'Label'),
            'place' => \Yii::t('app', 'Place'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(Images::className(), ['id' => 'image_id']);
    }
}

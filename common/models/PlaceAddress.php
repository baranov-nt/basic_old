<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "place_address".
 *
 * @property integer $id
 * @property string $place_id
 * @property integer $city_id
 *
 * @property PlaceCity $city
 */
class PlaceAddress extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'place_address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['place_id', 'city_id'], 'required'],
            [['city_id'], 'integer'],
            [['place_id'], 'string', 'max' => 255],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => PlaceCity::className(), 'targetAttribute' => ['city_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app', 'ID'),
            'place_id' => \Yii::t('app', 'Place ID'),
            'city_id' => \Yii::t('app', 'City ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(PlaceCity::className(), ['id' => 'city_id']);
    }
}

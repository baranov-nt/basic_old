<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "place_region".
 *
 * @property integer $id
 * @property string $place_id
 * @property integer $country_id
 *
 * @property PlaceCity[] $placeCities
 * @property PlaceCountry $country
 */
class PlaceRegion extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'place_region';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['country_id'], 'required'],
            [['country_id'], 'integer'],
            [['place_id'], 'string', 'max' => 255],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => PlaceCountry::className(), 'targetAttribute' => ['country_id' => 'id']],
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
            'country_id' => \Yii::t('app', 'Country ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlaceCities()
    {
        return $this->hasMany(PlaceCity::className(), ['region_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(PlaceCountry::className(), ['id' => 'country_id']);
    }
}

<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "place_country".
 *
 * @property integer $id
 * @property string $iso2
 * @property string $short_name
 * @property string $long_name
 * @property string $iso3
 * @property string $numcode
 * @property string $un_member
 * @property string $calling_code
 * @property string $cctld
 * @property integer $phone_number_digits_code
 * @property string $currency
 * @property integer $system_measure
 *
 * @property PlaceRegion[] $placeRegions
 * @property User[] $users
 */
class PlaceCountry extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'place_country';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['short_name', 'long_name'], 'required'],
            [['phone_number_digits_code', 'system_measure'], 'integer'],
            [['iso2'], 'string', 'max' => 2],
            [['short_name', 'long_name'], 'string', 'max' => 80],
            [['iso3', 'currency'], 'string', 'max' => 3],
            [['numcode'], 'string', 'max' => 6],
            [['un_member'], 'string', 'max' => 12],
            [['calling_code'], 'string', 'max' => 8],
            [['cctld'], 'string', 'max' => 5],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app', 'ID'),
            'iso2' => \Yii::t('app', 'Iso2'),
            'short_name' => \Yii::t('app', 'Short Name'),
            'long_name' => \Yii::t('app', 'Long Name'),
            'iso3' => \Yii::t('app', 'Iso3'),
            'numcode' => \Yii::t('app', 'Numcode'),
            'un_member' => \Yii::t('app', 'Un Member'),
            'calling_code' => \Yii::t('app', 'Calling Code'),
            'cctld' => \Yii::t('app', 'Cctld'),
            'phone_number_digits_code' => \Yii::t('app', 'Phone Number Digits Code'),
            'currency' => \Yii::t('app', 'Currency'),
            'system_measure' => \Yii::t('app', 'System Measure'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlaceRegions()
    {
        return $this->hasMany(PlaceRegion::className(), ['country_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['country_id' => 'id']);
    }
}

<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "auth_social".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $source
 * @property string $source_id
 *
 * @property User $user
 * @property AuthSocial[] $country
 */
class AuthSocial extends ActiveRecord
{
    public $social;
    public $email;
    public $firstName;
    public $lastName;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auth_social';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'source', 'source_id'], 'required'],
            [['user_id'], 'integer'],
            [['source', 'source_id'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['social', 'email', 'firstName', 'lastName'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app', 'ID'),
            'user_id' => \Yii::t('app', 'User ID'),
            'source' => \Yii::t('app', 'Source'),
            'source_id' => \Yii::t('app', 'Source ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function setSocialAttributes($attributes)
    {
        $this->setCountry();
        $this->source_id = (string)$attributes['id'];
        $this->social = \Yii::$app->request->get('authclient');
        switch ($this->social) {
            case 'google':
                $this->email = $attributes['emails'][0]['value'];
                $this->firstName = $attributes['name']['givenName'];
                $this->lastName = $attributes['name']['familyName'];
                break;
            case 'yandex':
                $this->email = $attributes['default_email'];
                $this->firstName = $attributes['first_name'];
                $this->lastName = $attributes['last_name'];
                break;
            break;
            case 'facebook':
                $name = explode(' ', $attributes['name']);
                $this->email = $attributes['email'];
                $this->firstName = $name[0];
                $this->lastName = $name[1];
                break;
            case 'vkontakte':
                $this->firstName = $attributes['first_name'];
                $this->lastName = $attributes['last_name'];
                break;
            case 'twitter':
                $name = explode(' ', $attributes['name']);
                $this->firstName = $name[0];
                $this->lastName = $name[1];
                break;
            case 'linkedin':
                $this->email = $attributes['email-address'];
                $this->firstName = $attributes['first-name'];
                $this->lastName = $attributes['last-name'];
                break;
        }
    }

    public function setCountry()
    {
        switch (\Yii::$app->language) {
            case 'en':
                $this->country = 236;
                break;
            case 'ru':
                $this->country = 182;
                break;
            case 'fr':
                $this->country = 76;
                break;
            case 'de':
                $this->country = 83;
                break;
        }
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: phpNT
 * Date: 02.05.2015
 * Time: 18:17
 */

namespace frontend\models;

use common\models\PlaceCountry;
use yii\base\Model;
use common\rbac\helpers\RbacHelper;
use common\models\User;
use common\models\UserProfile;
use yii\helpers\ArrayHelper;

/* @property SignupForm[] $countriesList */
/* @property string $callingCode */
/* @property SignupForm[] $countriesList */
/* @property PlaceCountry $modelPlaceCountry */

class SignupForm extends Model
{
    public $phone;
    public $phoneNumberDigitsCode;
    public $email;
    public $password;
    public $status;
    public $location;
    public $password_repeat;
    public $country_iso;
    public $hasEmail;

    public function rules()
    {
        return [
            [['phone', 'email', 'password'],'filter', 'filter' => 'trim'],
            [['country_iso', 'phone', 'email'],'required', 'on' => [
                'emailActivation',
                'phoneActivation',
                'emailSocialActivation',
                'phoneSocialActivation']],
            [['password', 'password_repeat'],'required', 'on' => [
                'emailActivation',
                'phoneActivation']],
            [['phone'], 'integer'],
            ['phone', 'validatePhone'],
            [['country_iso'], 'string'],
            ['password', 'string', 'min' => 6, 'max' => 255],
            ['email', 'email'],
            //['hasEmail', 'email'],
            ['phone', 'unique',
                'targetClass' => User::className(),
                'message' => \Yii::t('app', 'This phone is already registered.')],
            ['email', 'unique',
                'targetClass' => User::className(),
                'message' => \Yii::t('app', 'This email is already registered.'),
                'on' => [
                    'emailActivation',
                    'phoneActivation',
            ]],
            ['status', 'in', 'range' =>[
                User::STATUS_NOT_ACTIVE,
                User::STATUS_ACTIVE
            ]],
            ['status', 'default', 'value' => User::STATUS_ACTIVE, 'on' => [
                'phoneActivation',
                'phoneSocialActivation']],
            ['status', 'default', 'value' => User::STATUS_NOT_ACTIVE, 'on' => [
                'emailActivation',
                'emailSocialActivation']],
            ['password_repeat', 'compare', 'compareAttribute'=>'password', 'message'=> \Yii::t('app', 'Passwords are not equal.')],
        ];
    }

    public function validatePhone()
    {
        $this->setPhoneAttributes();
        $phone = str_replace(['\\', '_', '-'], '', $this->phone);

        if ($this->phoneNumberDigitsCode == null) {
            if (strlen($phone) < 5) {
                dd(1);
                $this->addError('phone', \Yii::t('app', 'Phone should contain {length, number} digits.', ['length' => '5-12']));
            }
            if (strlen($phone) > 12) {
                dd(2);
                $this->addError('phone', \Yii::t('app', 'Phone should contain {length, number} digits.', ['length' => '5-12']));
            }
        }

        if ($this->phoneNumberDigitsCode != strlen($phone) && $this->phoneNumberDigitsCode != null) {
            $this->addError('phone', \Yii::t('app', 'Phone should contain {length, number} digits.', ['length' => ($this->phoneNumberDigitsCode)]));
        }

        $phone = $this->getPhoneNumber();
        $modelUser = User::findOne(['phone' => $phone]);
        if($modelUser):
            $this->addError('phone', \Yii::t('app', 'This phone is already registered.'));
        endif;
    }

    public function attributeLabels()
    {
        return [
            'phone' => \Yii::t('app', 'Phone number'),
            'email' => \Yii::t('app', 'Email'),
            'password' => \Yii::t('app', 'Password'),
            'location' => \Yii::t('app', 'City'),
            'country_iso' => \Yii::t('app', 'Country'),
            'password_repeat' => \Yii::t('app', 'Confirm password')
        ];
    }

    public function sendActivationEmail($user)
    {
        return \Yii::$app->mailer->compose('activationEmail', ['user' => $user])
            ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::t('app', '{app_name} (sent a robot).', ['app_name' => \Yii::$app->name])])
            ->setTo($this->email)
            ->setSubject(\Yii::t('app', 'Activation for {app_name}.', ['app_name' => \Yii::$app->name]))
            ->send();
    }

    /**
     * Returns the array of possible user status values.
     *
     * @return array
     */
    public function getCountriesList()
    {
        $modelPlaceCountry = PlaceCountry::find()
            ->asArray()
            ->all();
        $countriesArray = ArrayHelper::map($modelPlaceCountry,
            'iso2',
            function($modelPlaceCountry) {
                return \Yii::t('countries', $modelPlaceCountry['short_name']);
            }
        );

        return $countriesArray;
    }

    /**
     * Returns the array of possible user status values.
     *
     * @return array
     */
    public function getPhoneNumber()
    {
        /* @var $modelPlaceCountry \common\models\PlaceCountry */
        $phone = $this->callingCode.$this->phone;
        $phone = str_replace([' ', '-', '+', '(', ')'], '', $phone);
        return $phone;
    }

    /**
     * Returns the array of possible user status values.
     *
     * @return array
     */
    public function getCallingCode()
    {
        /* @var $modelPlaceCountry \common\models\PlaceCountry */
        $modelPlaceCountry = PlaceCountry::findOne(['iso2' => $this->country_iso]);
        return $modelPlaceCountry->calling_code;
    }

    /**
     * Returns the array of possible user status values.
     *
     * @return array
     */
    public function setPhoneAttributes()
    {
        /* @var $modelPlaceCountry \common\models\PlaceCountry */
        $modelPlaceCountry = PlaceCountry::findOne(['iso2' => $this->country_iso]);
        if($modelPlaceCountry) {
            $this->phoneNumberDigitsCode = $modelPlaceCountry->phone_number_digits_code;
        }
    }

    public function signup($id = null)
    {
        /* @var $modelUser \common\models\User */
        /* @var $modelPlaceCountry \common\models\PlaceCountry */

        if($this->validate()) {
            $modelUser = $id ? User::findOne($id) : new User();
            $modelPlaceCountry = $modelUser->getModelPlaceCountryByIso2($this->country_iso);
            $modelUser->phone_short = $this->phone;
            $modelUser->phone = $this->getPhoneNumber();
            if ($modelUser->email === null) {
                $modelUser->email = $this->email;
            }
            $modelUser->balance = 0;
            $modelUser->status = $this->status;
            $modelUser->country_id = $modelPlaceCountry->id;
            $modelUser->setPassword($this->password);
            $modelUser->generateAuthKey();
            if ($this->scenario === 'emailActivation' || $this->scenario === 'emailSocialActivation') {
                $modelUser->generateSecretKey();
            }
            if ($modelUser->save()):
                /* @var $modelUserProfile UserProfile */
                $modelUserProfile = ($modelUserProfile = UserProfile::findOne($modelUser->id)) ? $modelUserProfile : new UserProfile();
                $modelUserProfile->link('user', $modelUser);
                return RbacHelper::assignRole($modelUser->getId()) ? $modelUser : null;
            endif;
        }
        return false;
    }

    public function socialSignup($id)
    {
        /* @var $modelUser \common\models\User */
        /* @var $modelPlaceCountry \common\models\PlaceCountry */
        $modelUser = User::findOne($id);

        $modelPlaceCountry = $modelUser->getModelPlaceCountryByIso2($this->country_iso);

        if($this->scenario === 'phoneFinish'):
            $modelUser->phone = $this->getPhoneNumber();
            $modelUser->status = User::STATUS_ACTIVE;
            $modelUser->country_id = $modelPlaceCountry->id;
            $modelUser->setPassword(time());
            $modelUser->generateAuthKey();
            $modelUser->save();
            return RbacHelper::assignRole($modelUser->getId()) ? $modelUser : null;
        elseif($this->scenario === 'phoneAndEmailFinish'):
            $modelUser->phone = $this->getPhoneNumber();
            $modelUser->email = $this->email;
            $modelUser->country_id = $modelPlaceCountry->id;
            $modelUser->setPassword($this->password);
            $modelUser->generateAuthKey();
            $modelUser->generateSecretKey();
            $modelUser->validate();
            $modelUser->save();
            return RbacHelper::assignRole($modelUser->getId()) ? $modelUser : null;
        endif;
        return false;
    }
}
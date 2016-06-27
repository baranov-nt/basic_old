<?php
/**
 * Created by PhpStorm.
 * User: phpNT
 * Date: 02.05.2015
 * Time: 18:16
 */
namespace common\models;

use yii\base\Model;

class LoginForm extends Model
{
    public $username;
    public $phone;
    public $password;
    public $email;
    public $rememberMe = true;
    public $status;
    public $reCaptcha;

    private $_user = false;

    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
            [['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className(),
                'secret' => '6LcWAxMTAAAAAEZCbXGi-azhHhA8kYRq5WmY9pLg',
                'on' => 'loginWithCaptcha' //your secret key
            ]
        ];
    }

    public function validatePassword($attribute)
    {
        if (!$this->hasErrors()):
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)):
                $this->addError($attribute, \Yii::t('app', 'Wrong phone, email or password.'));
            endif;
        endif;
    }

    public function getUser()
    {
        if ($this->_user === false):
            $this->_user = User::findByEmail($this->username);
            if($this->_user):
                return $this->_user;
            else:
                $this->_user = User::findByphone($this->username);
            endif;
        endif;
        return $this->_user;
    }

    public function attributeLabels()
    {
        return [
            'username' => \Yii::t('app', 'Phone or email'),
            'phone' => \Yii::t('app', 'Phone number'),
            'email' => \Yii::t('app', 'Email'),
            'password' => \Yii::t('app', 'Password'),
            'rememberMe' => \Yii::t('app', 'Remember me'),
            'reCaptcha' => \Yii::t('app', 'Captha')
        ];
    }

    public function login()
    {
        /* @var $user User */
        if ($this->validate()) {
            $this->status = ($user = $this->getUser()) ? $user->status : null;
            if ($this->status === User::STATUS_ACTIVE) {
                return \Yii::$app->user->login($user, $this->rememberMe ? 3600 * 24 * 30 : 0);
            } elseif ($this->status === User::STATUS_DELETED) {
                \Yii::$app->session->setFlash('0',
                    [
                        'type' => 'danger',
                        'icon' => 'fa fa-ban',
                        'title' => '<strong>' . \Yii::t('app', 'Warning') . ':</strong><br>',
                        'message' => \Yii::t('app', 'User {name} is blocked!', ['name' => '<strong>' . $this->username . '</strong>']),
                    ]
                );
            } elseif ($this->status === User::STATUS_NOT_ACTIVE) {
                \Yii::$app->session->setFlash('0',
                    [
                        'type' => 'danger',
                        'icon' => 'fa fa-ban',
                        'title' => '<strong>' . \Yii::t('app', 'Warning') . ':</strong><br>',
                        'message' => \Yii::t('app', 'User {name} is not activated by email!', ['name' => '<strong>' . $this->username . '</strong>']),
                    ]
                );
            }
            return false;
        }
        \Yii::$app->session->setFlash('0',
            [
                'type' => 'danger',
                'icon' => 'fa fa-ban',
                'title' => '<strong>' . \Yii::t('app', 'Warning') . ':</strong><br>',
                'message' => \Yii::t('app', 'Wrong phone, email or password.'),
            ]
        );
        return false;
    }
}
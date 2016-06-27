<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 05.08.2015
 * Time: 15:21
 */

namespace frontend\models;

use yii\base\Model;
use common\models\User;

class SendEmailForm extends Model
{
    public $email;

    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => User::className(),
                'filter' => [
                    'status' => User::STATUS_ACTIVE
                ],
                'message' => \Yii::t('app', 'Sorry, we are unable to reset password for email provided.')
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => 'Емайл'
        ];
    }

    public function sendEmail()
    {
        /* @var $user User */
        $user = User::findOne(
            [
                'status' => User::STATUS_ACTIVE,
                'email' => $this->email
            ]
        );

        if($user):
            $user->generateSecretKey();
            if($user->save()):
                return \Yii::$app->mailer->compose('resetPassword', ['user' => $user])
                    ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name.' ('.\Yii::t('app', 'sent a robot').')'])
                    ->setTo($this->email)
                    ->setSubject(\Yii::t('app', 'Password reset for {name}.', ['name' => \Yii::$app->name]))
                    ->send();
            endif;
        endif;

        return false;
    }

}
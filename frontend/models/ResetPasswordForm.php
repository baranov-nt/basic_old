<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 05.08.2015
 * Time: 15:46
 */

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\base\InvalidParamException;
use common\models\User;

class ResetPasswordForm extends Model
{
    public $password;
    public $password_repeat;
    private $_user;

    public function rules()
    {
        return [
            ['password', 'required'],
            ['password_repeat', 'compare', 'compareAttribute'=>'password', 'message'=> \Yii::t('app', 'Passwords are not equal.')],
        ];
    }

    public function attributeLabels()
    {
        return [
            'password' => Yii::t('app', 'New password'),
            'password_repeat' => \Yii::t('app', 'Confirm password')
        ];
    }

    public function __construct($key, $config = [])
    {
        if(empty($key) || !is_string($key))
            throw new InvalidParamException(Yii::t('app', 'The key can not be empty.'));
        $this->_user = User::findBySecretKey($key);
        if(!$this->_user)
            throw new InvalidParamException(Yii::t('app', 'Invalid key.'));
        parent::__construct($config);
    }

    public function resetPassword()
    {
        /* @var $user User */
        $user = $this->_user;
        $user->setPassword($this->password);
        $user->removeSecretKey();
        return $user->save();
    }

}
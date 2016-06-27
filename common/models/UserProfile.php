<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "user_profile".
 *
 * @property integer $user_id
 * @property string $avatar
 * @property string $first_name
 * @property string $last_name
 * @property string $middle_name
 * @property integer $birthday
 * @property integer $gender
 *
 * @property User $user
 */
class UserProfile extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_profile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['birthday', 'gender'], 'integer'],
            [['avatar'], 'string', 'max' => 255],
            [['first_name', 'last_name', 'middle_name'], 'string', 'max' => 32],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => \Yii::t('app', 'User ID'),
            'avatar' => \Yii::t('app', 'Avatar'),
            'first_name' => \Yii::t('app', 'First Name'),
            'last_name' => \Yii::t('app', 'Last Name'),
            'middle_name' => \Yii::t('app', 'Middle Name'),
            'birthday' => \Yii::t('app', 'Birthday'),
            'gender' => \Yii::t('app', 'Gender'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}

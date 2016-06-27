<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "notice_service".
 *
 * @property integer $id
 * @property string $message
 * @property string $email
 * @property integer $user_id
 * @property boolean $seen
 * @property boolean $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 */
class NoticeService extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notice_service';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message', 'status'], 'required'],
            [['user_id', 'created_at', 'updated_at'], 'integer'],
            [['seen', 'status'], 'boolean'],
            [['message', 'email'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app', 'ID'),
            'message' => \Yii::t('app', 'Message'),
            'email' => \Yii::t('app', 'Email'),
            'user_id' => \Yii::t('app', 'User ID'),
            'seen' => \Yii::t('app', 'Seen'),
            'status' => \Yii::t('app', 'Status'),
            'created_at' => \Yii::t('app', 'Created At'),
            'updated_at' => \Yii::t('app', 'Updated At'),
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className()
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

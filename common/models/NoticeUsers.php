<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "notice_users".
 *
 * @property integer $id
 * @property string $message
 * @property boolean $private
 * @property integer $user_id
 * @property integer $to_user_id
 * @property integer $category
 * @property boolean $seen
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 * @property User $toUser
 */
class NoticeUsers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notice_users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message', 'user_id', 'created_at', 'updated_at'], 'required'],
            [['user_id', 'to_user_id', 'category', 'created_at', 'updated_at'], 'integer'],
            [['private', 'seen'], 'boolean'],
            [['message'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['to_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['to_user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'message' => Yii::t('app', 'Message'),
            'private' => Yii::t('app', 'Private'),
            'user_id' => Yii::t('app', 'User ID'),
            'to_user_id' => Yii::t('app', 'To User ID'),
            'category' => Yii::t('app', 'Category'),
            'seen' => Yii::t('app', 'Seen'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getToUser()
    {
        return $this->hasOne(User::className(), ['id' => 'to_user_id']);
    }
}

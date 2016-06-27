<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 29.04.2016
 * Time: 12:47
 */

namespace common\widgets\SlideReveal\models;

use yii\base\Model;
use common\models\NoticeService;

/**
 * @property array $statusList
 */

class NoticeServiceForm extends Model
{
    public $message;
    public $status;

    public function rules()
    {
        return [
            [['message', 'status'], 'required'],
            [['message'], 'string', 'max' => 255]
        ];
    }

    public function attributeLabels()
    {
        return [
            'message' => \Yii::t('app', 'Message'),
        ];
    }
    
    public function getStatusList() {
        $statusArray = [
            '1'     => \Yii::t('app', "Report a bug"),
            '0'     => \Yii::t('app', "Message to the administration"),
        ];
        return $statusArray;
    }

    public function saveMessage() {
        $modelNoticeService = new NoticeService();
        $modelNoticeService->message = $this->message;
        $modelNoticeService->status = $this->status;
        $modelNoticeService->user_id = \Yii::$app->user->id;
        if ($modelNoticeService->save()) {
            return true;
        }
        return false;
    }
}
<?php

namespace backend\models;

use common\models\NoticeService;
use common\models\User;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 * @property integer $countUsers
 * @property integer $countActiveUsers
 * @property integer $countNotActiveUsers
 * @property integer $countDeletedUsers
 * @property integer $countAllNotitesService
 * @property integer $countNewNotitesService
 * @property integer $countReportsBug
 * @property integer $countReportsAdmin
 */
class Statistics extends Model
{
    public $numberOfUsers;
    public $numberOfActiveUsers;
    public $numberOfNotActiveUsers;
    public $numberOfDeletedUsers;
    public $numberOfAllNotitesService;
    public $numberOfNewNotitesService;
    public $numberOfReportsBug;
    public $numberOfReportsAdmin;

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'numberOfUsers' => \Yii::t('app', 'Number of users:'),
            'numberOfActiveUsers' => \Yii::t('app', 'Number of active users:'),
            'numberOfNotActiveUsers' => \Yii::t('app', 'Number of not active users:'),
            'numberOfDeletedUsers' => \Yii::t('app', 'Number of blocked users:'),
            'numberOfAllNotitesService' => \Yii::t('app', 'Number of all service messages:'),
            'numberOfNewNotitesService' => \Yii::t('app', 'Number of new service messages:'),
            'numberOfReportsBug' => \Yii::t('app', 'Number of service messages about bugs:'),
            'numberOfReportsAdmin' => \Yii::t('app', 'Number of service messages to the app administration:'),
        ];
    }

    public function getCountUsers()
    {
        return User::find()->count();
    }

    public function getCountActiveUsers()
    {
        return User::find()->where(['status' => 10])->count();
    }

    public function getCountNotActiveUsers()
    {
        return User::find()->where(['status' => 0])->count();
    }

    public function getCountDeletedUsers()
    {
        return User::find()->where(['status' => 1])->count();
    }

    public function getCountAllNotitesService()
    {
        return NoticeService::find()->count();
    }

    public function getCountNewNotitesService()
    {
        return NoticeService::find()->where(['seen' => false])->count();
    }

    public function getCountReportsBug()
    {
        return NoticeService::find()->where(['status' => true])->count();
    }

    public function getCountReportsAdmin()
    {
        return NoticeService::find()->where(['status' => false])->count();
    }
}


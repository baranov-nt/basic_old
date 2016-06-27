<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 18.05.2016
 * Time: 11:16
 */

namespace frontend\controllers;

use common\models\AuthSocial;
use common\models\User;
use yii\helpers\Url;
use yii\web\Controller;
use common\models\UserProfile;
use yii\authclient\AuthAction;
use common\rbac\helpers\RbacHelper;

class AuthController extends Controller
{
    public function actions()
    {
        return [
            'index' => [
                'class' => AuthAction::className(),
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }

    public function onAuthSuccess($client)
    {
        /* @var $client \yii\authclient\OAuth2*/
        /* @var $user \common\models\User */
        $attributes = $client->getUserAttributes();

        /* @var $modelAuthSocial AuthSocial */
        $modelAuthSocial = AuthSocial::find()->where([
            'source' => $client->getId(),
            'source_id' => $attributes['id'],
        ])->one();

        $modelAuthSocial = $modelAuthSocial ? $modelAuthSocial : new AuthSocial();
        $modelAuthSocial->setSocialAttributes($attributes);
        $modelAuthSocial->source = $client->getId();

        if (\Yii::$app->user->isGuest) {
            if ($modelAuthSocial->isNewRecord) {
                /* пользователь не найден, регистрация */
                if ($modelUser = User::findOne(['email' => $modelAuthSocial->email])) {
                    // Если пользователь с емайл существует
                    if($modelUser) {
                        if ($modelUser->status == User::STATUS_DELETED) {
                            \Yii::$app->session->set(
                                'message',
                                [
                                    'type' => 'danger',
                                    'icon' => 'glyphicon glyphicon-alert',
                                    'message' => \Yii::t('app', "This user is blocked.")
                                ]
                            );
                            return $this->redirectUser($url = Url::to(['/site/index']));
                        } elseif ($modelUser->status == User::STATUS_ACTIVE) {
                            \Yii::$app->session->set(
                                'message',
                                [
                                    'type' => 'info',
                                    'icon' => 'glyphicon glyphicon-thumbs-up',
                                    'message' => \Yii::t('app', 'Welcome to {app}!', ['app' => \Yii::$app->name])
                                ]
                            );
                            \Yii::$app->user->login($modelUser);
                            return $this->redirectUser($url = Url::to(['/site/index']));
                        }
                    }

                    return $this->redirectUser($url = Url::to(['/site/login']));
                } else {
                    /* Это новый пользователь */
                    $modelUser = new User(['scenario' => 'social']);
                    $modelUser->email = $modelAuthSocial->email;
                    $modelUser->password_hash = \Yii::$app->security->generateRandomString(6);
                    $modelUser->status = User::STATUS_NOT_ACTIVE;
                    $modelUser->country_id = $modelAuthSocial->country;
                    $modelUser->generateAuthKey();
                    $modelUser->generateSecretKey();

                    $transaction = $modelUser->getDb()->beginTransaction();

                    if ($modelUser->save()) {
                        $modelAuthSocial->user_id = $modelUser->id;
                        if ($modelAuthSocial->save()) {
                            /* @var $modelProfile /common/models/UserProfile */
                            $modelProfile = new UserProfile();
                            $modelProfile->user_id = $modelUser->id;
                            $modelProfile->first_name = $modelAuthSocial->firstName;
                            $modelProfile->last_name = $modelAuthSocial->lastName;
                            if($modelProfile->save()):
                                if(RbacHelper::assignRole($modelUser->id)) {
                                    $transaction->commit();
                                }
                                return $this->redirectUser($url = Url::to(['/site/social-signup', 'id' => $modelUser->id]));
                            endif;
                        }
                    }
                }
            } else {
                /* Пользователь найден */
                $modelUser = $modelAuthSocial->user;
                if($modelUser->status == User::STATUS_NOT_ACTIVE):
                    if(\Yii::$app->params['emailActivation']) {
                        \Yii::$app->session->set(
                            'message',
                            [
                                'type' => 'info',
                                'icon' => 'glyphicon glyphicon-alert',
                                'message' => \Yii::t('app', "To complete registration, enter the phone number and confirm the e-mail address."),
                            ]
                        );
                    } else {
                        \Yii::$app->session->set(
                            'message',
                            [
                                'type' => 'info',
                                'icon' => 'glyphicon glyphicon-alert',
                                'message' => \Yii::t('app', "To complete registration, enter a phone number."),
                            ]
                        );
                    }
                    return $this->redirectUser($url = Url::to(['/site/social-signup', 'id' => $modelUser->id]));
                elseif($modelUser->status == User::STATUS_DELETED):
                    \Yii::$app->session->set(
                        'message',
                        [
                            'type' => 'danger',
                            'icon' => 'glyphicon glyphicon-alert',
                            'message' => \Yii::t('app', "This user is blocked.")
                        ]
                    );
                    return $this->redirectUser($url = Url::to(['/site/index']));
                endif;
                \Yii::$app->session->set(
                    'message',
                    [
                        'type' => 'info',
                        'icon' => 'glyphicon glyphicon-thumbs-up',
                        'message' => \Yii::t('app', 'Welcome to {app}!', ['app' => \Yii::$app->name])
                    ]
                );
                \Yii::$app->user->login($modelUser);
            }
        } else {
            if ($modelAuthSocial->isNewRecord) {
                if ($modelUser = User::findOne(['email' => $modelAuthSocial->email])) {
                    $modelAuthSocial->user_id = $modelUser->id;
                    $modelAuthSocial->save();
                } else {
                    $modelAuthSocial = new AuthSocial([
                        'user_id' => \Yii::$app->user->id,
                        'source' => $client->getId(),
                        'source_id' => $attributes['id'],
                    ]);
                    $modelAuthSocial->save();
                }
            }
        }
        return true;
    }

    public function redirectUser($url) {
        /* Если пользователь с таким эл. адресом существуе, делаем переход обратно на страницу входа */
        $viewFile = '@frontend/views/site' . DIRECTORY_SEPARATOR . 'redirect.php';  // файл перехода
        $viewData = [
            'url' =>$url,
            'enforceRedirect' => true,
        ];
        $response = \Yii::$app->getResponse();
        $response->content = \Yii::$app->getView()->renderFile($viewFile, $viewData);
        return $response;
    }
}
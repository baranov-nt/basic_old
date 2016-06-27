<?php
namespace frontend\controllers;

use common\models\LoginForm;
use common\models\User;
use frontend\models\AccountActivation;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SendEmailForm;
use frontend\models\SignupForm;
use yii\base\InvalidParamException;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;

/**
 * Site controller
 */
class SiteController extends BehaviorsController
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        $modelLoginForm = new LoginForm();
        if ($modelLoginForm->load(\Yii::$app->request->post())) {
            if ($modelLoginForm->login()) {
                return $this->goBack();
            }
        }
        return $this->render('login', [
            'model' => $modelLoginForm,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        \Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $emailActivation = \Yii::$app->params['emailActivation'];
        $modelSignupForm = $emailActivation ? new SignupForm(['scenario' => 'emailActivation']) : new SignupForm(['scenario' => 'phoneActivation']);

        if ($modelSignupForm->load(\Yii::$app->request->post()) && $modelSignupForm->validate()):
            if ($user = $modelSignupForm->signup()):
                if ($user->status === User::STATUS_ACTIVE):
                    /* @var $user User */
                    if (\Yii::$app->getUser()->login($user)):
                        \Yii::$app->redis->executeCommand('SET', ['users:signup:'.\Yii::$app->user->id, '1']);
                        \Yii::$app->redis->executeCommand('EXPIRE',['users:signup:'.\Yii::$app->user->id, 60]);
                        return $this->redirect('/user/profile/index');
                    endif;
                else:
                    if($modelSignupForm->sendActivationEmail($user)):
                        \Yii::$app->session->set(
                            'message',
                            [
                                'type'      => 'info',
                                'icon'      => 'glyphicon glyphicon-envelope',
                                'message'   => '<p style="text-align: justify">'.\Yii::t('app', 'Letter to activate your account was sent to the email <strong> {email} </strong> (check spam folder).', ['email' => $user->email]).'</p>',
                            ]
                        );
                        return $this->redirect(Url::to(['/site/index']));
                    else:
                        \Yii::$app->session->set(
                            'message',
                            [
                                'type'      => 'danger',
                                'icon'      => 'glyphicon glyphicon-envelope',
                                'message'   => \Yii::t('app', 'Error. The letter was not sent.'),
                            ]
                        );
                        \Yii::error(\Yii::t('app', 'Error. The letter was not sent.'));
                    endif;
                    return $this->refresh();
                endif;
            else:
                \Yii::$app->session->set(
                    'message',
                    [
                        'type'      => 'danger',
                        'icon'      => 'glyphicon glyphicon-envelope',
                        'message'   => \Yii::t('app', 'There was an error during the registration process.'),
                    ]
                );
                \Yii::error(\Yii::t('app', 'There was an error during the registration process.'));
                return $this->refresh();
            endif;
        endif;

        $modelSignupForm->setPhoneAttributes();

        return $this->render('signup', [
            'modelSignupForm' => $modelSignupForm,
        ]);
    }

    public function actionSocialSignup($id)
    {
        /* @var $modelUser \common\models\User */
        /* @var $modelSignupForm \frontend\models\SignupForm */

        $modelUser = User::findOne($id);

        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $emailActivation = \Yii::$app->params['emailActivation'];
        $modelSignupForm = $emailActivation ? new SignupForm(['scenario' => 'emailSocialActivation']) : new SignupForm(['scenario' => 'phoneSocialActivation']);

        if ($modelSignupForm->load(\Yii::$app->request->post()) && $modelSignupForm->validate()):
            if ($modelUser = $modelSignupForm->signup($id)):
                if ($modelUser->status === User::STATUS_ACTIVE):
                    if (\Yii::$app->getUser()->login($modelUser)):
                        return $this->goHome();
                    endif;
                else:
                    if($modelSignupForm->sendActivationEmail($modelUser)):
                        \Yii::$app->session->set(
                            'message',
                            [
                                'type'      => 'info',
                                'message'   => '<p style="text-align: justify">'.\Yii::t('app', 'Letter to activate your account was sent to the email <strong> {email} </strong> (check spam folder).', ['email' => $modelUser->email]).'</p>',
                            ]
                        );
                        return $this->redirect(Url::to(['/site/index']));
                    else:
                        \Yii::$app->session->set(
                            'message',
                            [
                                'type'      => 'danger',
                                'icon'      => 'glyphicon glyphicon-alert',
                                'message'   => \Yii::t('app', 'Error. The letter was not sent.')
                            ]
                        );
                        \Yii::error(\Yii::t('app', 'Error. The letter was not sent.'));
                    endif;
                    return $this->refresh();
                endif;
            else:
                \Yii::$app->session->set(
                    'message',
                    [
                        'type'      => 'danger',
                        'icon'      => 'glyphicon glyphicon-alert',
                        'message'   => \Yii::t('app', 'There was an error during the registration process.')
                    ]
                );
                \Yii::error(\Yii::t('app', 'There was an error during the registration process.'));
                return $this->refresh();
            endif;
        endif;

        return $this->render(
            'social-signup',
            [
                'modelUser'         => $modelUser,
                'modelSignupForm'   => $modelSignupForm
            ]
        );
    }

    public function actionUpdatePhone($id = null)
    {
        $emailActivation = \Yii::$app->params['emailActivation'];
        if ($id) {
            $modelSignupForm = $emailActivation ? new SignupForm(['scenario' => 'emailSocialActivation']) : new SignupForm(['scenario' => 'phoneSocialActivation']);
        } else {
            $modelSignupForm = $emailActivation ? new SignupForm(['scenario' => 'emailActivation']) : new SignupForm(['scenario' => 'phoneActivation']);
        }

        if ($modelSignupForm->load(\Yii::$app->request->post())):
            $modelSignupForm->setPhoneAttributes();
            if ($id) {
                $modelUser = User::findOne($id);

                return $this->render(
                    'social-signup',
                    [
                        'modelUser' => $modelUser,
                        'modelSignupForm' => $modelSignupForm,
                    ]
                );
            } else {
                return $this->render(
                    'signup',
                    [
                        'modelSignupForm' => $modelSignupForm,
                    ]
                );
            }
        endif;

        return $this->redirect('signup');
    }

    public function actionResetPassword($key)
    {
        try {
            $modelResetPasswordForm = new ResetPasswordForm($key);
        }
        catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($modelResetPasswordForm->load(\Yii::$app->request->post())) {
            if ($modelResetPasswordForm->validate() && $modelResetPasswordForm->resetPassword()) {
                \Yii::$app->session->set(
                    'message',
                    [
                        'type' => 'success',
                        'icon' => 'glyphicon glyphicon-envelope',
                        'message' => \Yii::t('app', 'Your password is changed.'),
                    ]
                );
                return $this->redirect(['/site/login']);
            }
        }

        return $this->render('resetPassword', [
            'modelResetPasswordForm' => $modelResetPasswordForm,
        ]);
    }

    public function actionSendEmail()
    {
        $modelSendEmailForm = new SendEmailForm();

        if ($modelSendEmailForm->load(\Yii::$app->request->post())) {
            if ($modelSendEmailForm->validate()) {
                if($modelSendEmailForm->sendEmail()) {
                    \Yii::$app->session->set(
                        'message',
                        [
                            'type' => 'warning',
                            'icon' => 'glyphicon glyphicon-envelope',
                            'message' => \Yii::t('app', 'Check your email for further instructions.'),
                        ]
                    );
                    return $this->goHome();
                }
            } else {
                \Yii::$app->session->set(
                    'message',
                    [
                        'type'      => 'danger',
                        'icon'      => 'glyphicon glyphicon-envelope',
                        'message'   => \Yii::t('app', 'Sorry, we are unable to reset password for email provided.'),
                    ]
                );
            }
        }

        return $this->render('sendEmail', [
            'modelSendEmailForm' => $modelSendEmailForm,
        ]);
    }

    public function actionActivateAccount($key)
    {
        /* @var $modelUser \common\models\User */

        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        try {
            $user = new AccountActivation($key);
        }
        catch(InvalidParamException $e) {
            \Yii::$app->session->set(
                'message',
                [
                    'type'      => 'danger',
                    'icon'      => 'glyphicon glyphicon-envelope',
                    'message'   => \Yii::t('app', 'Invalid key. Repeat registration.'),
                ]
            );
            throw new BadRequestHttpException($e->getMessage());
        }

        if($user = $user->activateAccount()) {
            /* @var $user User */
            \Yii::$app->session->set(
                'message',
                [
                    'type'      => 'success',
                    'icon'      => 'glyphicon glyphicon-envelope',
                    'message'   => \Yii::t('app', 'Activation was successful.'),
                ]
            );
            \Yii::$app->getUser()->login($user);
            return $this->redirect(['/user/profile/index']);
        } else {
            \Yii::$app->session->set(
                'message',
                [
                    'type'      => 'danger',
                    'icon'      => 'glyphicon glyphicon-envelope',
                    'message'   => \Yii::t('app', 'Activation error.'),
                ]
            );
        }

        return $this->redirect(Url::to(['/site/index']));
    }
}

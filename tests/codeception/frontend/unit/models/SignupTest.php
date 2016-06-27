<?php

namespace tests\codeception\frontend\unit\models;

use frontend\models\RegForm;
use frontend\models\SignupForm;
use tests\codeception\common\fixtures\AuthAssignmentFixture;
use tests\codeception\common\fixtures\UserFixture;
use tests\codeception\common\fixtures\UserProfileFixture;
use tests\codeception\frontend\unit\DbTestCase;
use Codeception\Specify;

class SignupTest extends DbTestCase
{
    use Specify;

    public function fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::className(),
            ],
            'userProfile' => [
                'class' => UserProfileFixture::className(),
            ],
            'authAssignment' => [
                'class' => AuthAssignmentFixture::className(),
            ],
        ];
    }

    public function testCorrectFindUser()
    {
        /*pd(array(
            $this->user('user1'),
            $this->userProfile('user1'),
            $this->userPrivilege('user1'),
            $this->authAssignment('user1')
        ));*/
        // @var $modelRegForm \common\models\RegForm
        $modelRegForm = new SignupForm([
            'country_id' => 182,
            'phone' => '9221301870',
            'email' => 'some_email@example.com',
            'password' => 'some_password',
            'password_repeat' => 'some_password'
        ]);

        $user = $modelRegForm->signup();

        $this->assertInstanceOf('common\models\User', $user, 'user should be valid');

        expect('username should be correct', $user->phone)->equals('9221301870');
        expect('email should be correct', $user->email)->equals('some_email@example.com');
        expect('password should be correct', $user->validatePassword('some_password'))->true();
    }

    /*public function testNotCorrectSignup()
    {
        $model = new RegForm([
            'phone' => '79333333333',
            'email' => 'some_email@example.com',
            'password' => 'some_password',
            'password_repeat' => 'some_password',
            'status' => 10,
            'country_id' => 182
        ]);

        expect('phone and email are in use, user should not be created', $model->reg())->null();
    }*/

    /*public function testCorrectDeleteUser()
    {
        // @var $modelUser \common\models\User
        $modelUser = User::findOne([
            'phone' => '79333333333',
            'email' => 'some_email@example.com',
        ]);
        pdd($modelUser);
        if($modelUser) {
            $modelUser->deleteUser($modelUser);
        }
    }*/
}

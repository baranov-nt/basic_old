<?php

namespace tests\codeception\frontend\unit\models;

use frontend\models\RegForm;
use tests\codeception\common\fixtures\AuthAssignmentFixture;
use tests\codeception\common\fixtures\UserFixture;
use tests\codeception\common\fixtures\UserProfileFixture;
use tests\codeception\frontend\unit\DbTestCase;
use Codeception\Specify;

class SignupFormTest extends DbTestCase
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
        $modelRegForm = new RegForm([
            'country_id' => 182,
            'phone' => '79883332211',
            'email' => 'some_email@example.com',
            'password' => 'some_password',
            'password_repeat' => 'some_password'
        ]);

        $user = $modelRegForm->reg();

        $this->assertInstanceOf('common\models\User', $user, 'user should be valid');

        expect('username should be correct', $user->phone)->equals('79883332211');
        expect('email should be correct', $user->email)->equals('some_email@example.com');
        expect('password should be correct', $user->validatePassword('some_password'))->true();
    }
}

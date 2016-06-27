<?php
namespace tests\codeception\frontend\AcceptanceTester;

use tests\codeception\common\_pages\LoginPage;
use Faker\Factory;

class LoginSteps extends \tests\codeception\frontend\AcceptanceTester
{
    public function amCheckValidationLoginForm($scenario)
    {
        $faker = Factory::create();
        $I = $this;
        $loginPage = LoginPage::openBy($I);
        $I->seeInTitle(\Yii::t('app', 'Войти'));
        $I->comment('Отправка пустой формы');
        $loginPage->login('', '');
        $I->wait(1);
        $I->see(\Yii::t('yii', '{attribute} cannot be blank.', ['attribute' => $loginPage->getLoginFormAttribute('username')]), '.help-block');
        $I->see(\Yii::t('yii', '{attribute} cannot be blank.', ['attribute' => $loginPage->getLoginFormAttribute('password')]), '.help-block');
        $I->comment('Отправка неверных данных');
        $loginPage->login($faker->email, 'some');
        $I->wait(1);
        $I->see(\Yii::t('app', 'Wrong phone, email or password.'), '.help-block');
    }

    public function amCorrectLoginWithPhone()
    {
        $I = $this;
        $loginPage = LoginPage::openBy($I);
        $loginPage->login('79221301879', 'v@v.com');
        $I->wait(1);
    }

    public function amCorrectLoginWithEmail()
    {
        $I = $this;
        $loginPage = LoginPage::openBy($I);
        $loginPage->login('v@v.com', 'v@v.com');
        $I->wait(1);
    }

    public function amLogout()
    {
        $I = $this;
        $I->click('#myAccount');
        $I->wait(1);
        $I->click('#logoutUser');
        $I->wait(1);
    }
}
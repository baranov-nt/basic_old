<?php
/**
 * Created by PhpStorm.
 * User: phpNT
 * Date: 24.04.2016
 * Time: 9:23
 */
namespace tests\codeception\frontend\AcceptanceTester;

use Faker\Factory;
use tests\codeception\frontend\_pages\SignupPage;

class SignupSteps extends \tests\codeception\frontend\AcceptanceTester
{
    public function amCheckValidationSignupForm($scenario)
    {
        $faker = Factory::create();
        $I = $this;
        $SignupPage = SignupPage::openBy($I);
        $I->seeInTitle(\Yii::t('app', 'Registration'));
        $I->comment('Отправка пустой формы');
        $SignupPage->signupNotFill('', '', '');
        $I->wait(1);
        $I->see(\Yii::t('yii', '{attribute} cannot be blank.', ['attribute' => $SignupPage->getSignupFormAttribute('country_id')]), '.help-block');
        $I->see(\Yii::t('yii', '{attribute} cannot be blank.', ['attribute' => $SignupPage->getSignupFormAttribute('email')]), '.help-block');
        $I->see(\Yii::t('yii', '{attribute} cannot be blank.', ['attribute' => $SignupPage->getSignupFormAttribute('password')]), '.help-block');
        $I->see(\Yii::t('yii', '{attribute} cannot be blank.', ['attribute' => $SignupPage->getSignupFormAttribute('password_repeat')]), '.help-block');
        $I->comment('Отправка заполенной формы формы');
        $country = rand(1, 250);
        $phone = rand(10000000000, 99999999999);
        $js = "$('#signupform-country_id').val(".$country.").trigger('change');";
        $I->executeJS($js);
        $I->wait(1);
        $SignupPage->signup($phone, $faker->email, 'password', 'passwordWrong');
        $I->wait(1);
        $I->see(\Yii::t('app', 'Passwords are not equal.'), '.help-block');
        $SignupPage->signup($phone, $faker->email, 'password', 'password');
        $I->wait(5);
        //$I->see(\Yii::t('app', 'Passwords are not equal.'), '.help-block');
    }
}
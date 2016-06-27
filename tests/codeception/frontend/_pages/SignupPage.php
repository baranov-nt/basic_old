<?php

namespace tests\codeception\frontend\_pages;

use frontend\models\SignupForm;
use \yii\codeception\BasePage;

/**
 * Represents signup page
 * @property \tests\codeception\frontend\AcceptanceTester | \tests\codeception\frontend\FunctionalTester $actor
 */
class SignupPage extends BasePage
{

    public $route = 'site/signup';

    /**
     * @param array $signupData
     */
    public function signupNotFill($email, $password, $password_repeat)
    {
        $this->actor->fillField('input[name="SignupForm[email]"]', $email);
        $this->actor->fillField('input[name="SignupForm[password]"]', $password);
        $this->actor->fillField('input[name="SignupForm[password_repeat]"]', $password_repeat);
        $this->actor->click('singupButton');
    }

    public function signup($phone, $email, $password, $password_repeat)
    {
        $this->actor->fillField('input[name="SignupForm[phone]"]', $phone);
        $this->actor->fillField('input[name="SignupForm[email]"]', $email);
        $this->actor->fillField('input[name="SignupForm[password]"]', $password);
        $this->actor->fillField('input[name="SignupForm[password_repeat]"]', $password_repeat);
        $this->actor->click('singupButton');
    }

    public function getSignupFormAttribute($attribute)
    {
        $modelSignupForm = new SignupForm();
        $attribute = $modelSignupForm->getAttributeLabel($attribute);
        return $attribute;
    }
}

<?php

namespace tests\codeception\common\_pages;

use common\models\LoginForm;
use yii\codeception\BasePage;

/**
 * Represents loging page
 * @property \tests\codeception\frontend\AcceptanceTester | \tests\codeception\frontend\FunctionalTester | \tests\codeception\backend\AcceptanceTester| \tests\codeception\backend\FunctionalTester $actor
 */
class LoginPage extends BasePage
{
    public $route = 'site/login';

    /**
     * @param string $username
     * @param string $password
     */
    public function login($username, $password)
    {
        $this->actor->fillField('input[name="LoginForm[username]"]', $username);
        $this->actor->fillField('input[name="LoginForm[password]"]', $password);
        $this->actor->click('loginButton');
    }

    public function getLoginFormAttribute($attribute)
    {
        $modelLoginForm = new LoginForm();
        $attribute = $modelLoginForm->getAttributeLabel($attribute);
        return $attribute;
    }
}

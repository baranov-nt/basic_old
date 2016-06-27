<?php
/**
 * Created by PhpStorm.
 * User: phpNT
 * Date: 24.04.2016
 * Time: 9:22
 */
use tests\codeception\frontend\AcceptanceTester;

$I = new AcceptanceTester\SignupSteps($scenario);
$I->comment('Проверка регистрации пользователей');
$I->amCheckValidationSignupForm($scenario);
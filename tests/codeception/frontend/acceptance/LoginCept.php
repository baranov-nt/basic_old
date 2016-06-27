<?php
use tests\codeception\frontend\AcceptanceTester;

$I = new AcceptanceTester\LoginSteps($scenario);
$I->comment('Проверка авторизации пользователей');
$I->amCheckValidationLoginForm($scenario);
$I->comment('Отправка верных данных');
$I->comment('Заходим используя телефон');
$I->amCorrectLoginWithPhone();
$I->comment('Переадресация на главную страницу');
$I->amOnPage('');
$I->seeInTitle(Yii::$app->name);
$I->comment('Выход пользователя');
$I->amLogout();
$I->amOnPage('');
$I->seeInTitle(Yii::$app->name);
$I->comment('Заходим используя емайл');
$I->amCorrectLoginWithEmail();
$I->comment('Переадресация на главную страницу');
$I->amOnPage('');
$I->seeInTitle(Yii::$app->name);

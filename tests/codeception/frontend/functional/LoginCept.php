<?php
use tests\codeception\frontend\FunctionalTester;
use tests\codeception\frontend\_pages\LoginPage;

$I = new FunctionalTester($scenario);
$I->wantTo('Войти на страницу входа пользователя.');
LoginPage::openBy($I);
$I->seeElement('.main-login');
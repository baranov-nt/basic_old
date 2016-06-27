<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 20.04.2016
 * Time: 14:05
 */

namespace tests\codeception\common\fixtures;

use yii\test\ActiveFixture;

class UserProfileFixture extends ActiveFixture
{
    public $modelClass = 'common\models\UserProfile';
    public $dataFile = '@tests/codeception/common/fixtures/data/userProfile.php';
    public $depends = ['tests\codeception\common\fixtures\UserFixture'];
}
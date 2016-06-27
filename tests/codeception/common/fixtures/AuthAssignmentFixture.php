<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 20.04.2016
 * Time: 17:57
 */

namespace tests\codeception\common\fixtures;

use yii\test\ActiveFixture;

class AuthAssignmentFixture extends ActiveFixture
{
    public $modelClass = 'common\models\AuthAssignment';
    public $dataFile = '@tests/codeception/common/fixtures/data/authAssignment.php';
    public $depends = ['tests\codeception\common\fixtures\UserProfileFixture'];
}
<?php
namespace common\rbac\rules;

use common\rbac\models\AuthItem;
use yii\rbac\Rule;

/**
 * Checks if authorID matches user passed via params
 */
class AuthorRule extends Rule
{
    public $name = 'Автор';

    /**
     * @param  string|integer $user   The user ID.
     * @param  AuthItem           $item   The role or permission that this rule is associated with
     * @param  array          $params Parameters passed to ManagerInterface::checkAccess().
     * @return boolean                A value indicating whether the rule permits the role or 
     *                                permission it is associated with.
     */
    public function execute($user, $item, $params)
    {
        return isset($params['model']) ? $params['model']->createdBy == $user : false;
    }
}
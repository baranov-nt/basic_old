<?php
namespace console\controllers;

use yii\helpers\Console;
use yii\console\Controller;

/**
 * Контроль доступа на основе ролей.
 * -----------------------------------------------------------------------------
 * Создание ролей:
 *
 * - Создатель      : может все.
 * - Администратор  : может все.
 * - Редактор       : может добавлять и редактировать контент. Не может управлять пользователями
 * - Премиум        : допольнительные опции для пользователей
 * - Пользователь   : обычный пользователь
 *
 * Создание разрешений:
 *
 * - Использовать премиум
 * - Управлять объявлениями
 * - Добавлять объявления
 * - Редактировать объявления
 * - Удалять объявления
 * - Управлять пользователями
 * - Просматривать пользователей
 *
 * Создание правила:
 *
 * - Автор
 */
class RbacController extends Controller
{
    /**
     * Инициализация RBAC.
     */
    public function actionInit()
    {
        $auth = \Yii::$app->authManager;

        //---------- Правила ----------//

        $rule = new \common\rbac\rules\AuthorRule;
        $auth->add($rule);

        //---------- РАЗРЕШЕНИЯ ----------//

        // добавить "Использовать премиум" разрешение
        $usePremiumContent = $auth->createPermission('Использовать премиум');
        $usePremiumContent->description = 'Позволяет использовать премиум контент';
        $auth->add($usePremiumContent);

        // добавить "Добавлять объявления" разрешение
        $addAds = $auth->createPermission('Добавлять объявления');
        $addAds->description = 'Позволяет добавлять объявления';
        $auth->add($addAds);

        // добавить "Редактировать объявления" разрешение
        $updateAds = $auth->createPermission('Редактировать объявления');
        $updateAds->description = 'Позволяет редактировать объявления';
        $auth->add($updateAds);

        // добавить "Удалять объявления" разрешение
        $deleteAds = $auth->createPermission('Удалять объявления');
        $deleteAds->description = 'Позволяет удалять объявления';
        $auth->add($deleteAds);

        // добавить "Управлять пользователями" разрешение
        $manageUsers = $auth->createPermission('Управлять пользователями');
        $manageUsers->description = 'Позволяет управлять пользователями';
        $auth->add($manageUsers);

        // добавить "Управлять пользователями" разрешение
        $viewUsers = $auth->createPermission('Просматривать пользователей');
        $viewUsers->description = 'Позволяет просматривать пользователей';
        $auth->add($viewUsers);

        // add the "updateOwnAds" permission and associate the rule with it.
        $updateOwnAds = $auth->createPermission('Автор');
        $updateOwnAds->description = 'Редактировать свои объявления';
        $updateOwnAds->ruleName = $rule->name;
        $auth->add($updateOwnAds);

        // "updateOwnAds" will be used from "updateAds"
        $auth->addChild($updateOwnAds, $updateAds);

        //---------- РОЛИ ----------//

        // "Пользователь"
        // Проверка на автора Yii::$app->user->can('Автор', $modelAdRealEstate->adCategory->adMain->user_id)
        $member = $auth->createRole('Пользователь');
        $member->description = 'Роль. Простой пользователь, зарегистрированный на сайте.';
        $auth->add($member);
        $auth->addChild($member, $updateOwnAds);

        // "Премиум"
        $premium = $auth->createRole('Премиум');
        $premium->description = 'Роль. Премиум пользователь. Который имеет больше возможностей, чем простой пользователь.';
        $auth->add($premium);
        $auth->addChild($premium, $member);
        $auth->addChild($premium, $usePremiumContent);

        // "Редактор"
        $editor = $auth->createRole('Редактор');
        $editor->description = 'Роль. Модератор. Управление объявлениями.';
        $auth->add($editor);
        $auth->addChild($editor, $premium);
        $auth->addChild($editor, $addAds);
        $auth->addChild($editor, $updateAds);
        $auth->addChild($editor, $deleteAds);
        $auth->addChild($editor, $viewUsers);

        // "Администратор"
        $admin = $auth->createRole('Администратор');
        $admin->description = 'Роль. Администратор. Управление объявлениями и пользователями.';
        $auth->add($admin);
        $auth->addChild($admin, $editor);
        $auth->addChild($admin, $manageUsers);

        // "Создатель"
        $theCreator = $auth->createRole('Создатель');
        $theCreator->description = 'Роль. Создатель. Управление всем.';
        $auth->add($theCreator); 
        $auth->addChild($theCreator, $admin);

        if ($auth) 
        {
            $this->stdout("\nRbac authorization data are installed successfully.\n", Console::FG_GREEN);
        }
    }
}
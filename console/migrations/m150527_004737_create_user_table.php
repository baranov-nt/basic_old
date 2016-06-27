<?php

use yii\db\Migration;

class m150527_004737_create_user_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('user', [
            'id'            => $this->primaryKey(),
            'phone_short'   => $this->string(11),
            'phone'         => $this->string(20)->unique(),
            'email'         => $this->string(64)->unique(),
            'balance'       => $this->money(11, 2),
            'password_hash' => $this->string()->notNull(),
            'status'        => $this->smallInteger(2)->notNull(),
            'country_id'    => $this->integer()->notNull(),
            'auth_key'      => $this->string(32)->notNull(),
            'secret_key'    => $this->string(),
            'created_at'    => $this->integer()->notNull(),
            'updated_at'    => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('auth_assignment_user', 'auth_assignment', 'user_id', 'user', 'id', 'CASCADE');
        $this->addForeignKey('auth_user_id', 'auth_social', 'user_id', 'user', 'id', 'CASCADE');

        /* Таблица профиля пользователя */
        $this->createTable(
            'user_profile',
            [
                'user_id'       => $this->primaryKey(),
                'avatar'        => $this->string(),
                'first_name'    => $this->string(32)->defaultValue(''),
                'last_name'     => $this->string(32)->defaultValue(''),
                'middle_name'   => $this->string(32)->defaultValue(''),
                'birthday'      => $this->integer(),
                'gender'        => $this->smallInteger()
            ]
        );
        $this->addForeignKey('profile_user', 'user_profile', 'user_id', 'user', 'id', 'cascade', 'cascade');
    }

    public function safeDown()
    {
        $this->dropForeignKey('privilege_user', 'user_privilege');
        $this->dropTable('user_privilege');
        $this->dropTable('user');
    }
    
    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }
    
    public function safeDown()
    {
    }
    */
}

<?php

use yii\db\Migration;

class m160429_060221_notice_tables extends Migration
{
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->createTable('notice_service', [
            'id'            => $this->primaryKey(),
            'message'       => $this->text()->notNull(),
            'email'         => $this->string()->defaultValue(null),             // емайл (если не авторизован)
            'user_id'       => $this->integer()->defaultValue(null),            // от кого
            'seen'          => $this->boolean()->defaultValue(false),           // флаг просмотра
            'status'        => $this->boolean()->defaultValue(false),           // флаг (сообщение об ошибке или простое уведомление)
            'created_at'    => $this->integer()->notNull(),
            'updated_at'    => $this->integer()->notNull(),
        ]);

        $this->createTable('notice_users', [
            'id'            => $this->primaryKey(),
            'message'       => $this->text()->notNull(),
            'private'       => $this->boolean()->defaultValue(false),           // флаг личного сообщения
            'user_id'       => $this->integer()->notNull(),                     // от кого
            'to_user_id'    => $this->integer()->defaultValue(null),            // кому
            'category'      => $this->integer(2)->defaultValue(null),           // категория, где было отправлено сообщение
            'seen'          => $this->boolean()->defaultValue(false),           // флаг просмотра
            'created_at'    => $this->integer()->notNull(),
            'updated_at'    => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('notice_service_user', 'notice_service', 'user_id', 'user', 'id', 'CASCADE');
        $this->addForeignKey('notice_user_user', 'notice_users', 'user_id', 'user', 'id', 'CASCADE');
        $this->addForeignKey('notice_to_user_user', 'notice_users', 'to_user_id', 'user', 'id', 'CASCADE');
    }

    public function safeDown()
    {
    }

}

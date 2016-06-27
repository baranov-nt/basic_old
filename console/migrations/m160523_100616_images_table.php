<?php

use yii\db\Migration;

class m160523_100616_images_table extends Migration
{
    public function up()
    {
        $this->createTable('images_example', [
            'id'            => $this->primaryKey(),
            'image_path'   => $this->string()->notNull(),
        ]);

        $this->addForeignKey('auth_assignment_user', 'auth_assignment', 'user_id', 'user', 'id');
        $this->addForeignKey('auth_user_id', 'auth_social', 'user_id', 'user', 'id', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('images_example');
    }
}

<?php

use yii\db\Migration;

class m151022_045706_images_of_object extends Migration
{
    /*
     * Создание таблицы avatar_images для связи много ко многим
     * */
    public function safeUp()
    {
        $this->createTable('images_of_object', [
            'id'        => $this->primaryKey(),
            'image_id'  => $this->integer(),
            'object_id' => $this->integer(),
            'label'     => $this->integer(),
            'place'     => $this->smallInteger(),
        ]);
        $this->createIndex('FK_image', 'images_of_object', 'image_id');
        $this->addForeignKey('images_of_object', 'images_of_object', 'image_id', 'images', 'id');              // связь таблицы images с таблицей images_of_object, один ко многим
    }

    public function safeDown()
    {
        $this->dropColumn('images_of_object', 'object_id');
        $this->dropColumn('images_of_object', 'image_id');
        $this->dropTable('images_of_object');
    }
}

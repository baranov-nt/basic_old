<?php
/**
 * @link https://github.com/himiklab/yii2-ipgeobase-component
 * @copyright Copyright (c) 2014 HimikLab
 * @license http://opensource.org/licenses/MIT MIT
 */

use yii\db\Migration;

class m141125_101036_ip_geobase extends Migration
{
    public function up()
    {
        $this->createTable('geobase_ip', [
            'ip_begin' => $this->bigInteger(20),
            'ip_end' => $this->bigInteger(20),
            'country_code' => $this->string(2)->notNull(),
            'city_id' => $this->integer(6)->unsigned()->notNull()
        ]);

        $this->createTable('geobase_city', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull(),
            'region_id' => $this->integer(),
            'latitude' => $this->double(),
            'longitude' => $this->double(),
        ]);

        $this->createTable('geobase_region', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable(self::DB_IP_TABLE_NAME);
        $this->dropTable(self::DB_CITY_TABLE_NAME);
        $this->dropTable(self::DB_REGION_TABLE_NAME);
    }
}

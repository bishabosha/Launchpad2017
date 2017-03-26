<?php

use yii\db\Migration;

class m170326_050132_addLatLngToAddress extends Migration
{
    public function up()
    {
        $this->addColumn('{{%addresses}}', 'latlng', 'VARCHAR(60)');
    }

    public function down()
    {
        echo "m170326_050132_addLatLngToAddress cannot be reverted.\n";

        return false;
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

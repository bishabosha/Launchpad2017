<?php

use yii\db\Migration;

class m170326_060107_addRequestsToEvent extends Migration
{
    public function up()
    {
        $this->addColumn('{{%event}}', 'requests', \yii\db\Schema::TYPE_STRING);
    }

    public function down()
    {
        echo "m170326_060107_addRequestsToEvent cannot be reverted.\n";

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

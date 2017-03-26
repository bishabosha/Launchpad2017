<?php

use yii\db\Migration;

class m170325_233136_addRatingToUser extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', 'rating', 'FLOAT DEFAULT 0');
        $this->addColumn('{{%user}}', 'joined', 'DATETIME');
    }

    public function down()
    {
        echo "m170325_233136_addRatingToUser cannot be reverted.\n";

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

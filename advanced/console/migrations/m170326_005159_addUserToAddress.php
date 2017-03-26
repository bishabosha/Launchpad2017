<?php

use yii\db\Migration;

class m170326_005159_addUserToAddress extends Migration
{
    public function up()
    {
        $this->addColumn('{{%addresses}}', 'userId', 'int(11)');

        $this->addForeignKey(
            'FK_userId',
            '{{%addresses}}',
            'userId',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        echo "m170326_005159_addUserToAddress cannot be reverted.\n";

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

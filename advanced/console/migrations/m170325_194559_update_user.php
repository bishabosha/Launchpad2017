<?php

use yii\db\Migration;

class m170325_194559_update_user extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->dropColumn('{{%user}}', 'username');
        $this->addColumn('{{%user}}', 'firstname', 'VARCHAR(50)');
        $this->addColumn('{{%user}}', 'lastname', 'VARCHAR(50)');

    }

    public function down()
    {
        echo "m170325_194559_update_user cannot be reverted.\n";

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

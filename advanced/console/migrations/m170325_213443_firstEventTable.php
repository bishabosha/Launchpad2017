<?php

use yii\db\Migration;

class m170325_213443_firstEventTable extends Migration
{
    public function up()
    {
        $this->createTable('{{%event}}', [
            'eventId' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'timestamp' => $this->dateTime()->notNull(),
            'price' => $this->integer()->notNull(),
            'capacity' => $this->integer()->notNull(),
            'attending' => $this->string()->notNull(),
            'hostId' => $this->integer()->notNull(),
            'addressId' => $this->integer()->notNull(),
            'description' => $this->string()->notNull(),
        ]);

        $this->createTable('{{%addresses}}', [
            'addressId' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'street1' => $this->string()->notNull(),
            'street2' => $this->string(),
            'city' => $this->string()->notNull(),
            'postcode' => $this->string()->notNull(),
        ]);

        $this->addForeignKey(
            'FK_addressId',
            '{{%event}}',
            'addressId',
            '{{%addresses}}',
            'addressId',
            'CASCADE'
        );

        $this->addForeignKey(
            'FK_hostId',
            '{{%event}}',
            'hostId',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        echo "m170325_213443_firstEventTable cannot be reverted.\n";

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

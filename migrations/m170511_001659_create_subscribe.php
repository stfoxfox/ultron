<?php

use yii\db\Migration;

class m170511_001659_create_subscribe extends Migration
{
    public function up()
    {
        $this->db->createCommand("CREATE TABLE `subscribe` (
`id`  int NOT NULL ,
`email`  varchar(128) NOT NULL ,
`created_at`  timestamp NOT NULL ,
PRIMARY KEY (`id`)
);")->execute();
    }

    public function down()
    {
        echo "m170511_001659_create_subscribe cannot be reverted.\n";

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

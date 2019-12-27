<?php

use yii\db\Migration;

class m170511_003517_create_subscribe extends Migration
{
    public function up()
    {
$this->db->createCommand("ALTER TABLE `user`
MODIFY COLUMN `status`  varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'enabled' AFTER `comment`;

")->execute();
    }

    public function down()
    {
        echo "m170511_003517_create_subscribe cannot be reverted.\n";

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

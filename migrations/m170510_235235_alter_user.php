<?php

use yii\db\Migration;

class m170510_235235_alter_user extends Migration
{
    public function up()
    {
$this->db->createCommand("ALTER TABLE `user`
MODIFY COLUMN `picture`  varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `last_name`;

")->execute();
    }

    public function down()
    {
        echo "m170510_235235_alter_user cannot be reverted.\n";

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

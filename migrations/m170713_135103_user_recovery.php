<?php

use yii\db\Migration;

class m170713_135103_user_recovery extends Migration
{
    public function up()
    {
        $this->db->createCommand("ALTER TABLE `user`
            ADD COLUMN `recovery_key`  varchar(32) NULL AFTER `last_visit`,
            ADD COLUMN `recovery_key_datetime`  datetime NULL AFTER `recovery_key`;")
            ->execute();
    }

    public function down()
    {
        echo "m170713_135103_user_recovery cannot be reverted.\n";

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

<?php

use yii\db\Migration;

class m170523_191722_alter_user_table extends Migration
{
    public function up()
    {
        $this->db->createCommand("ALTER TABLE `user`
            MODIFY COLUMN `status`  varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'pending' AFTER `comment`,
            MODIFY COLUMN `email_confirmation`  varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `password_hash`;
        ")->execute();
    }

    public function down()
    {
        echo "m170523_191722_alter_user_table cannot be reverted.\n";

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

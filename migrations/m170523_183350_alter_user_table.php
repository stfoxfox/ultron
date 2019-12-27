<?php

use yii\db\Migration;

class m170523_183350_alter_user_table extends Migration
{
    public function up()
    {
$this->db->createCommand("ALTER TABLE `user`
ADD COLUMN `email_confirmation`  varchar(64) NULL AFTER `password_hash`;")->execute();
    }

    public function down()
    {
        echo "m170523_183350_alter_user_table cannot be reverted.\n";

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

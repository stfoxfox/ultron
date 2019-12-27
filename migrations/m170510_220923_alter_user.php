<?php

use yii\db\Migration;

class m170510_220923_alter_user extends Migration
{
    public function up()
    {
        $this->db->createCommand("ALTER TABLE `user`
ADD COLUMN `default_payment_system`  varchar(32) NOT NULL DEFAULT 'yandex_money' AFTER `yandex_money`;

")->execute();
    }

    public function down()
    {
        echo "m170510_220923_alter_user cannot be reverted.\n";

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

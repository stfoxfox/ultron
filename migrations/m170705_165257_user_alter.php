<?php

use yii\db\Migration;

class m170705_165257_user_alter extends Migration
{
    public function up()
    {
    $this->db->createCommand("ALTER TABLE `user`
        ADD COLUMN `sales_count`  int(11) UNSIGNED NOT NULL DEFAULT 0 AFTER `purchases_count`;")
        ->execute();
    }

    public function down()
    {
        echo "m170705_165257_user_alter cannot be reverted.\n";

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

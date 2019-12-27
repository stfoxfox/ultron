<?php

use yii\db\Migration;

class m170704_112919_alter_payout_table extends Migration
{
    public function up()
    {
$this->db->createCommand("ALTER TABLE `payout`
MODIFY COLUMN `sum`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0 AFTER `user_id`,
MODIFY COLUMN `status`  varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'pending' AFTER `sum`;

")->execute();
    }

    public function down()
    {
        echo "m170704_112919_alter_payout_table cannot be reverted.\n";

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

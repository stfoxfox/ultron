<?php

use yii\db\Migration;

class m170705_185357_alter_payout extends Migration
{
    public function up()
    {
$this->db->createCommand("ALTER TABLE `payout`
DROP COLUMN `status`,
DROP COLUMN `paid_at`;")->execute();
    }

    public function down()
    {
        echo "m170705_185357_alter_payout cannot be reverted.\n";

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

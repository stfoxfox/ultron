<?php

use yii\db\Migration;

class m170704_090734_alter_invoice_table extends Migration
{
    public function up()
    {
$this->db->createCommand("ALTER TABLE `invoice`
DROP COLUMN `payout`;

")->execute();
    }

    public function down()
    {
        echo "m170704_090734_alter_invoice_table cannot be reverted.\n";

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

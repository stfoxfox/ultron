<?php

use yii\db\Migration;

class m170704_202404_invoice_order_id extends Migration
{
    public function up()
    {
$this->db->createCommand("ALTER TABLE `invoice`
DROP COLUMN `template_id`;
")->execute();
    }

    public function down()
    {
        echo "m170704_202404_invoice_order_id cannot be reverted.\n";

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

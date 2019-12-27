<?php

use yii\db\Migration;

class m170704_210403_invoice_alter extends Migration
{
    public function up()
    {
$this->db->createCommand("ALTER TABLE `invoice`
DROP COLUMN `user_email`;

")->execute();
    }

    public function down()
    {
        echo "m170704_210403_invoice_alter cannot be reverted.\n";

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

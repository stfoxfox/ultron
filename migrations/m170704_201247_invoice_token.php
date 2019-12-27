<?php

use yii\db\Migration;

class m170704_201247_invoice_token extends Migration
{
    public function up()
    {
$this->db->createCommand("ALTER TABLE `invoice`
ADD COLUMN ` token`  varchar(32) NOT NULL AFTER `status`;

")->execute();
    }

    public function down()
    {
        echo "m170704_201247_invoice_token cannot be reverted.\n";

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

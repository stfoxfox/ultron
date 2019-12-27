<?php

use yii\db\Migration;

class m170704_203153_create_invoice_template extends Migration
{
    public function up()
    {
        $this->db->createCommand("CREATE TABLE `invoice_template` (
        `id`  int(10) UNSIGNED NOT NULL ,
        `invoice_id`  int(10) UNSIGNED NOT NULL ,
        `template_id`  int(10) UNSIGNED NOT NULL ,
        `price`  int(10) UNSIGNED NOT NULL ,
        PRIMARY KEY (`id`)
        );")->execute();
    }

    public function down()
    {
        echo "m170704_203153_create_invoice_template cannot be reverted.\n";

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

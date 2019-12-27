<?php

use yii\db\Migration;

class m170704_203609_create_invoice_template_service extends Migration
{
    public function up()
    {
        $this->db->createCommand("DROP TABLE invoice_service;")->execute();

$this->db->createCommand("CREATE TABLE `invoice_template_service` (
  `invoice_template_id` int(10) unsigned NOT NULL,
  `service_id` int(10) unsigned NOT NULL,
  `price` int(10) unsigned NOT NULL,
  PRIMARY KEY (`invoice_template_id`,`service_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;")->execute();
    }

    public function down()
    {
        echo "m170704_203609_create_invoice_template_service cannot be reverted.\n";

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

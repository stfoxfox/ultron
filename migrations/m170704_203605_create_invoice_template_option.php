<?php

use yii\db\Migration;

class m170704_203605_create_invoice_template_option extends Migration
{
    public function up()
    {
        $this->db->createCommand("DROP TABLE invoice_option;")->execute();

$this->db->createCommand("CREATE TABLE `invoice_template_option` (
  `invoice_template_id` int(10) unsigned NOT NULL,
  `option_id` int(10) unsigned NOT NULL,
  `price` int(10) unsigned NOT NULL,
  PRIMARY KEY (`invoice_template_id`,`option_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
")->execute();
    }

    public function down()
    {
        echo "m170704_203605_create_invoice_template_option cannot be reverted.\n";

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

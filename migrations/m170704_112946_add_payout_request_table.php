<?php

use yii\db\Migration;

class m170704_112946_add_payout_request_table extends Migration
{
    public function up()
    {
$this->db->createCommand("CREATE TABLE `income` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `template_id` int(10) unsigned DEFAULT NULL,
  `sum` decimal(5,2) unsigned NOT NULL DEFAULT '0.00',
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;")->execute();
    }

    public function down()
    {
        echo "m170704_112946_add_income_table cannot be reverted.\n";

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

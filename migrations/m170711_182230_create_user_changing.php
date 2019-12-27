<?php

use yii\db\Migration;

class m170711_182230_create_user_changing extends Migration
{
    public function up()
    {
$this->db->createCommand("CREATE TABLE `user_changing` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `first_name` varchar(32) DEFAULT NULL,
  `last_name` varchar(32) DEFAULT NULL,
  `picture` varchar(64) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `phone` varchar(32) DEFAULT NULL,
  `skype` varchar(128) DEFAULT NULL,
  `password_hash` varchar(128) DEFAULT NULL,
  `default_payment_system` varchar(32) DEFAULT 'yandex_money',
  `confirmation_code` int(8) unsigned DEFAULT NULL,
  `status` varchar(32) DEFAULT 'pending',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

")->execute();
    }

    public function down()
    {
        echo "m170711_182230_create_user_changing cannot be reverted.\n";

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

<?php

use yii\db\Migration;

class m170705_162203_income_alter extends Migration
{
    public function up()
    {
$this->db->createCommand("ALTER TABLE `income`
CHANGE COLUMN `template_id` `invoice_id`  int(10) UNSIGNED NULL DEFAULT NULL AFTER `user_id`;")->execute();
    }

    public function down()
    {
        echo "m170705_162203_income_alter cannot be reverted.\n";

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

<?php

use yii\db\Migration;

class m170705_182456_alter_income extends Migration
{
    public function up()
    {
$this->db->createCommand("ALTER TABLE `income`
MODIFY COLUMN `sum`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00 AFTER `template_id`;")->execute();
    }

    public function down()
    {
        echo "m170705_182456_alter_income cannot be reverted.\n";

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

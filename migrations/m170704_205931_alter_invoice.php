<?php

use yii\db\Migration;

class m170704_205931_alter_invoice extends Migration
{
    public function up()
    {
$this->db->createCommand("ALTER TABLE `invoice_template`
MODIFY COLUMN `id`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT FIRST ;")->execute();

$this->db->createCommand("ALTER TABLE `invoice_template_option`
MODIFY COLUMN `invoice_template_id`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT FIRST ;")->execute();

$this->db->createCommand("ALTER TABLE `invoice_template_service`
MODIFY COLUMN `invoice_template_id`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT FIRST ;")->execute();
    }

    public function down()
    {
        echo "m170704_205931_alter_invoice cannot be reverted.\n";

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

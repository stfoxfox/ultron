<?php

use yii\db\Migration;

class m170704_210843_alter_invoice_service extends Migration
{
    public function up()
    {
        $this->db->createCommand("ALTER TABLE `invoice_template_service`
MODIFY COLUMN `invoice_template_id`  int(10) UNSIGNED NOT NULL ,
ADD COLUMN `id`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT FIRST ,
DROP PRIMARY KEY,
ADD PRIMARY KEY (`id`);
")->execute();
    }

    public function down()
    {
        echo "m170704_210843_alter_invoice_service cannot be reverted.\n";

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

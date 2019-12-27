<?php

use yii\db\Migration;

class m170704_205823_alter_invoice extends Migration
{
    public function up()
    {
$this->db->createCommand("ALTER TABLE `invoice`
CHANGE COLUMN ` token` `token`  varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `status`;
")->execute();
    }

    public function down()
    {
        echo "m170704_205823_alter_invoice cannot be reverted.\n";

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

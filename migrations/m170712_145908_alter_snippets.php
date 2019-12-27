<?php

use yii\db\Migration;

class m170712_145908_alter_snippets extends Migration
{
    public function up()
    {
$this->db->createCommand("ALTER TABLE `snippet`
ADD COLUMN `description`  varchar(255) NOT NULL AFTER `value`;")->execute();
    }

    public function down()
    {
        echo "m170712_145908_alter_snippets cannot be reverted.\n";

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

<?php

use yii\db\Migration;

class m170607_181551_alter_template extends Migration
{
    public function up()
    {
$this->db->createCommand("ALTER TABLE `template`
ADD COLUMN `comment`  varchar(255) NULL AFTER `hosting_id`;

")->execute();
    }

    public function down()
    {
        echo "m170607_181551_alter_template cannot be reverted.\n";

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

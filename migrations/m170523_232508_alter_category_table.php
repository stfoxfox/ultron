<?php

use yii\db\Migration;

class m170523_232508_alter_category_table extends Migration
{
    public function up()
    {
        $this->db->createCommand("ALTER TABLE `seller_request`
ADD COLUMN `message`  text NULL AFTER `email`;
")->execute();
    }

    public function down()
    {
        echo "m170523_232508_alter_category_table cannot be reverted.\n";

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

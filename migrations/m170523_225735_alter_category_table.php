<?php

use yii\db\Migration;

class m170523_225735_alter_category_table extends Migration
{
    public function up()
    {
        $this->db->createCommand("ALTER TABLE `category`
            ADD COLUMN `is_published`  tinyint(1) UNSIGNED NULL DEFAULT 1 AFTER `alias`;
        ")->execute();
    }

    public function down()
    {
        echo "m170523_225735_alter_category_table cannot be reverted.\n";

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

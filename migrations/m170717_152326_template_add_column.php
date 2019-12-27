<?php

use yii\db\Migration;

class m170717_152326_template_add_column extends Migration
{
    public function up()
    {
$this->db->createCommand("alter table `template` add column is_deleted tinyint(1) unsigned null default 0 after comment;")->execute();
    }

    public function down()
    {
        echo "m170717_152326_template_add_column cannot be reverted.\n";

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

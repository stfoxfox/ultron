<?php

use yii\db\Migration;

class m170510_225815_alter_download extends Migration
{
    public function up()
    {
$this->db->createCommand("ALTER TABLE `download`
ADD COLUMN `template_id`  int(10) UNSIGNED NOT NULL AFTER `id`;

")->execute();
    }

    public function down()
    {
        echo "m170510_225815_alter_download cannot be reverted.\n";

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

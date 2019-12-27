<?php

use yii\db\Migration;

class m170511_002830_create_subscribe extends Migration
{
    public function up()
    {
$this->db->createCommand("ALTER TABLE `subscribe`
MODIFY COLUMN `id`  int(11) UNSIGNED NOT NULL AUTO_INCREMENT FIRST ;

")->execute();
    }

    public function down()
    {
        echo "m170511_002830_create_subscribe cannot be reverted.\n";

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

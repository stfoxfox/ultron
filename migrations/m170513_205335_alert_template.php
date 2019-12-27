<?php

use yii\db\Migration;

class m170513_205335_alert_template extends Migration
{
    public function up()
    {
        $this->db->createCommand("ALTER TABLE `template`
DROP COLUMN `type`,
ADD COLUMN `type_id`  int(10) UNSIGNED NOT NULL AFTER `user_id`;


")->execute();
    }

    public function down()
    {
        echo "m170513_205335_alert_template cannot be reverted.\n";

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

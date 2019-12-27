<?php

use yii\db\Migration;

class m170817_183623_slider_snippet extends Migration
{
    public function up()
    {
        $sql = "ALTER TABLE `slider`
ADD COLUMN `snippet`  text NULL AFTER `url_title`;";
        Yii::$app->db->createCommand($sql)->execute();
    }

    public function down()
    {
        echo "m170817_183623_slider_snippet cannot be reverted.\n";

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

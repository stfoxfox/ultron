<?php

use yii\db\Migration;

/**
 * Class m191101_122831_user_alter_table_created_at_column
 */
class m191101_122831_user_alter_table_created_at_column extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $sql = "ALTER TABLE `user` CHANGE `created_at` `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP";
        Yii::$app->db->createCommand($sql)->execute();

    }

    public function down()
    {
        echo "m191101_122831_user_alter_table_created_at_column cannot be reverted.\n";

        return false;
    }
}

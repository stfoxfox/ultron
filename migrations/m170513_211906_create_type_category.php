<?php

use yii\db\Migration;

class m170513_211906_create_type_category extends Migration
{
    public function up()
    {
        $this->db->createCommand("CREATE TABLE `type_category` (
`type_id`  int(10) UNSIGNED NOT NULL ,
`category_id`  int(10) UNSIGNED NOT NULL ,
PRIMARY KEY (`type_id`, `category_id`)
)
;

")->execute();
    }

    public function down()
    {
        echo "m170513_211906_create_type_category cannot be reverted.\n";

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

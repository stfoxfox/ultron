<?php

use yii\db\Migration;

class m170513_211942_create_category_tag extends Migration
{
    public function up()
    {
        $this->db->createCommand("CREATE TABLE `category_tag` (
`category_id`  int(10) UNSIGNED NOT NULL ,
`tag_id`  int(10) UNSIGNED NOT NULL ,
PRIMARY KEY (`category_id`, `tag_id`)
)
;

")->execute();
    }

    public function down()
    {
        echo "m170513_211942_create_category_tag cannot be reverted.\n";

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

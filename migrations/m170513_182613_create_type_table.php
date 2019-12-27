<?php

use yii\db\Migration;

/**
 * Handles the creation of table `type`.
 */
class m170513_182613_create_type_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->db->createCommand("CREATE TABLE `type` (
`id`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
`title`  varchar(255) NOT NULL ,
`short_title`  varchar(255) NOT NULL ,
`description`  text NOT NULL ,
`alias`  varchar(255) NOT NULL ,
`picture`  varchar(64) NOT NULL ,
`ordering`  int(10) NOT NULL ,
PRIMARY KEY (`id`)
)
;
")->execute();
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('type');
    }
}

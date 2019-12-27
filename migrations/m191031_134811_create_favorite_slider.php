<?php

use yii\db\Migration;

/**
 * Class m191031_134811_create_favorite_slider
 */
class m191031_134811_create_favorite_slider extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable("favorite_template", [
            "id" => $this->primaryKey(),
            "template_id" => $this->integer(11)->unsigned(),
        ]);

        $this->createIndex("favorite_template-idx", "favorite_template", "template_id");

        $this->addForeignKey("favorite_template-template_id-fkey", "favorite_template", "template_id", "template", "id", "CASCADE", "CASCADE");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey("favorite_template-template_id-fkey", "favorite_template");
        $this->dropTable("favorite_template");
    }

}

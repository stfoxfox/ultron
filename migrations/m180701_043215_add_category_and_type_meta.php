<?php

use yii\db\Migration;

/**
 * Class m180701_043215_add_category_and_type_meta
 */
class m180701_043215_add_category_and_type_meta extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%category}}', 'meta_keywords', $this->text());
        $this->addColumn('{{%category}}', 'meta_description', $this->text());

        $this->addColumn('{{%type}}', 'meta_keywords', $this->text());
        $this->addColumn('{{%type}}', 'meta_description', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%category}}', 'meta_keywords');
        $this->dropColumn('{{%category}}', 'meta_description');
        $this->dropColumn('{{%type}}', 'meta_keywords');
        $this->dropColumn('{{%type}}', 'meta_description');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180701_043215_add_category_and_type_meta cannot be reverted.\n";

        return false;
    }
    */
}

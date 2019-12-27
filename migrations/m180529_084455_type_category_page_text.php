<?php

use yii\db\Migration;

/**
 * Class m180529_084455_create_template_type
 */
class m180529_084455_type_category_page_text extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%type}}', 'page_text', $this->text());
        $this->addColumn('{{%category}}', 'page_text', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%category}}', 'page_text');
        $this->dropColumn('{{%type}}', 'page_text');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180529_084455_create_template_type cannot be reverted.\n";

        return false;
    }
    */
}

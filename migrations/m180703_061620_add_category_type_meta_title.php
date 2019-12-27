<?php

use yii\db\Migration;

/**
 * Class m180703_061620_add_category_type_meta_title
 */
class m180703_061620_add_category_type_meta_title extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%category}}', 'meta_title', $this->text());
        $this->addColumn('{{%type}}', 'meta_title', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%category}}', 'meta_title');
        $this->dropColumn('{{%type}}', 'meta_title');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180703_061620_add_category_type_meta_title cannot be reverted.\n";

        return false;
    }
    */
}

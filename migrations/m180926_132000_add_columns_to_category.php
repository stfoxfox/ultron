<?php

use yii\db\Migration;

/**
 * Class m180926_132000_add_columns_to_category
 */
class m180926_132000_add_columns_to_category extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%category}}', 'heading', $this->string());
        $this->addColumn('{{%category}}', 'description', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%category}}', 'description');
        $this->dropColumn('{{%type}}', 'heading');
    }

}

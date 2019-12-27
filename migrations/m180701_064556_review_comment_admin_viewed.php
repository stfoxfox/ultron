<?php

use yii\db\Migration;

/**
 * Class m180701_064556_review_comment_admin_viewed
 */
class m180701_064556_review_comment_admin_viewed extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%comment}}', 'is_admin_viewed', $this->boolean()->defaultValue(false));
        $this->addColumn('{{%review}}', 'is_admin_viewed', $this->boolean()->defaultValue(false));

        $this->update('{{%comment}}', [
            'is_admin_viewed' => true
        ]);
        $this->update('{{%review}}', [
            'is_admin_viewed' => true
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%review}}', 'is_admin_viewed');
        $this->dropColumn('{{%comment}}', 'is_admin_viewed');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180701_064556_review_comment_admin_viewed cannot be reverted.\n";

        return false;
    }
    */
}

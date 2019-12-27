<?php

use yii\db\Migration;

/**
 * Class m180226_110215_add_rview_model_template
 */
class m180226_110215_add_review_model_template extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('{{%reviews_model}}', [
            'id' => 1726029766,
            'name' => 'app\models\Template',
            'status_id' => 1,
            'created_at' => time(),
            'updated_at' => time()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%reviews_model}}', 'name=:name', [
            'name' => 'app\models\Template'
        ]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180226_110215_add_rview_model_template cannot be reverted.\n";

        return false;
    }
    */
}

<?php

use yii\db\Migration;

/**
 * Class m180226_065731_template_notice
 */
class m180226_065731_template_notice extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%template_notice}}', [
            'user_id' => $this->integer(10)->notNull()->unsigned(),
            'template_id' => $this->integer(10)->notNull()->unsigned(),
            'receive_flag' => $this->boolean()->defaultValue(true)->comment('Получать уведомления')
        ], ' COMMENT "Кому отправлять уведомления об отзывах к шаблонам."');
        $this->addPrimaryKey('pk_template_notice', '{{%template_notice}}', 'user_id', 'template_id');
        $this->addForeignKey('fk_template_notice_user_id', '{{%template_notice}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_template_notice_template_id', '{{%template_notice}}', 'template_id', '{{%template}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_template_notice_template_id', '{{%template_notice}}');
        $this->dropForeignKey('fk_template_notice_user_id', '{{%template_notice}}');
        $this->dropTable('{{%template_notice}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180226_065731_template_notice cannot be reverted.\n";

        return false;
    }
    */
}

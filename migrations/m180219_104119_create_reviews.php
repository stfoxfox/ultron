<?php

use yii\db\Migration;
use yii\db\Schema;

class m180219_104119_create_reviews extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;

        // MySql table options
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        // Comment models table
        $this->createTable('{{%reviews_model}}', [
            'id' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL PRIMARY KEY',
            'name' => Schema::TYPE_STRING . '(255) NOT NULL',
            'status_id' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 1',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL'
        ], $tableOptions);

        $this->createIndex('name', '{{%reviews_model}}', 'name');
        $this->createIndex('status_id', '{{%reviews_model}}', 'status_id');
        $this->createIndex('created_at', '{{%reviews_model}}', 'created_at');
        $this->createIndex('updated_at', '{{%reviews_model}}', 'updated_at');

        // Comments table
        $this->createTable('{{%review}}', [
            'id' => Schema::TYPE_PK,
            'parent_id' => Schema::TYPE_INTEGER,
            'model_class' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
            'model_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'author_id' => Schema::TYPE_INTEGER . '(10) UNSIGNED NOT NULL',
            'content' => Schema::TYPE_TEXT . ' NOT NULL',
            'status_id' => 'tinyint(2) NOT NULL DEFAULT 0',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL'
        ], $tableOptions);

        // Indexes
        $this->createIndex('status_id', '{{%review}}', 'status_id');
        $this->createIndex('created_at', '{{%review}}', 'created_at');
        $this->createIndex('updated_at', '{{%review}}', 'updated_at');

        // Foreign Keys
        $this->addForeignKey('FK_comment_parent', '{{%review}}', 'parent_id', '{{%review}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('FK_comment_author', '{{%review}}', 'author_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('FK_comment_model_class', '{{%review}}', 'model_class', '{{%reviews_model}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropTable('{{%review}}');
        $this->dropTable('{{%reviews_model}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180219_104119_create_reviews cannot be reverted.\n";

        return false;
    }
    */
}

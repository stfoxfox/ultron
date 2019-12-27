<?php

use yii\db\Migration;

class m170720_181054_insert_new_snippets extends Migration
{
    public function up()
    {
$this->db->createCommand("INSERT INTO `snippet` (`key`, `value`, `description`) VALUES ('template-hint-title', 'test', 'Название шаблона');
INSERT INTO `snippet` (`key`, `value`, `description`) VALUES ('template-hint-type', 'test', 'Тип шаблона');
INSERT INTO `snippet` (`key`, `value`, `description`) VALUES ('template-hint-demo-url', 'test', 'Ссылка на демо-версию');
INSERT INTO `snippet` (`key`, `value`, `description`) VALUES ('template-hint-categories', 'test', 'Категории шаблона');
INSERT INTO `snippet` (`key`, `value`, `description`) VALUES ('template-hint-price', 'test', 'Цена');
INSERT INTO `snippet` (`key`, `value`, `description`) VALUES ('template-hint-new-price', 'test', 'Новая цена');
INSERT INTO `snippet` (`key`, `value`, `description`) VALUES ('template-hint-discount-date', 'Если указать дату окончания акции, то у товара будет отображаться счетчик обратного отсчета до указанной даты', 'Дата окончания акции');
INSERT INTO `snippet` (`key`, `value`, `description`) VALUES ('template-hint-is-free', 'Если вы отмечаете данный шаблон, как бесплатный, то он будет доступен для скачивания\r\n     без оплаты и регистрации!', 'Бесплатный шаблон');
INSERT INTO `snippet` (`key`, `value`, `description`) VALUES ('template-hint-tags', 'test', 'Теги');
INSERT INTO `snippet` (`key`, `value`, `description`) VALUES ('template-hint-description', 'test', 'Текстовое описание');
INSERT INTO `snippet` (`key`, `value`, `description`) VALUES ('template-hint-features', 'test', 'Возможности');
INSERT INTO `snippet` (`key`, `value`, `description`) VALUES ('template-hint-version-history', 'test', 'История версий');
INSERT INTO `snippet` (`key`, `value`, `description`) VALUES ('template-hint-file', 'test', 'Загрузить архив шаблона');
INSERT INTO `snippet` (`key`, `value`, `description`) VALUES ('template-hint-images', 'Допустимые типы файлов: .jpg, .jpeg, .png размером не более 2 мб', 'Загрузить до 4 изображений шаблона');")->execute();
    }

    public function down()
    {
        echo "m170720_181054_insert_new_snippets cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}

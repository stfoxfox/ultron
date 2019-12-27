<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "page".
 *
 * @property integer $id
 * @property string $title
 * @property string $alias
 * @property string $content
 */
class Page extends CommonModel
{

    const ROUTE_VIEW = 'page';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'page';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'alias', 'content'], 'required'],
            [['content', 'meta_description', 'meta_keywords'], 'string'],
            [['title', 'alias'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '№',
            'title' => 'Заголовок',
            'alias' => 'ЧПУ',
            'content' => 'Содержание',
            'meta_description' => 'Метатег description',
            'meta_keywords' => 'Метатег keywords'
        ];
    }

    public function getAvailableTags() {
        return [
            'title',
            'keywords',
            'description'
        ];
    }
}

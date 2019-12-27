<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "category_tag".
 *
 * @property integer $category_id
 * @property integer $tag_id
 */
class CategoryTag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category_tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'tag_id'], 'required'],
            [['category_id', 'tag_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'category_id' => 'Category ID',
            'tag_id' => 'Tag ID',
        ];
    }
}

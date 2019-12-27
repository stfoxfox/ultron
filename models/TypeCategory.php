<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "type_category".
 *
 * @property integer $type_id
 * @property integer $category_id
 */
class TypeCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'type_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_id', 'category_id'], 'required'],
            [['type_id', 'category_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'type_id' => 'Type ID',
            'category_id' => 'Category ID',
        ];
    }
}

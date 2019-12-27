<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "snippet".
 *
 * @property integer $id
 * @property string $key
 * @property string $value
 * @property string $description
 */
class Snippet extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'snippet';
    }

    /**
     * @param $key
     * @return array|null|\yii\db\ActiveRecord|Snippet
     */
    public static function findByKey($key)
    {
        return self::find()->where([
            'key' => $key,
        ])->one();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['key', 'value'], 'required'],
            [['value'], 'string'],
            [['key', 'description'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '#',
            'key' => 'Ключ',
            'value' => 'Значение',
            'description' => 'Описание',
        ];
    }
}

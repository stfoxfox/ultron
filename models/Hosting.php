<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hosting".
 *
 * @property integer $id
 * @property string $title
 * @property string $url
 */
class Hosting extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hosting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'url'], 'required'],
            [['title', 'url'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '№',
            'title' => 'Название',
            'url' => 'Ссылка',
        ];
    }
}

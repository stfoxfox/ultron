<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "template_file".
 *
 * @property integer $id
 * @property integer $template_id
 * @property string $original_name
 * @property string $file_name
 * @property integer $size
 * @property string $created_at
 */
class TemplateFile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'template_file';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            [
                'class' => TimestampBehavior::className(),
                'updatedAtAttribute' => false,
                'value' => new Expression('NOW()'),
            ],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '№',
            'template_id' => 'Шаблон',
            'original_name' => 'Название',
            'file_name' => 'Название',
            'size' => 'Размер',
            'created_at' => 'Дата',
            'file' => 'Загрузить архив шаблона',
        ];
    }
}

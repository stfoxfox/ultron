<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "option".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $price
 * @property integer $is_required
 *
 * @property TemplateOption[] $templateOptions
 * @property Template[] $templates
 */
class Option extends \yii\db\ActiveRecord
{
    /**
     * @return array
     */
    public static function getOptions()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'title');
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'option';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'description', 'price'], 'required'],
            [['title', 'description'], 'string'],
            [['price'], 'integer'],
            [['is_required'], 'integer'],
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
            'description' => 'Описание',
            'price' => 'Цена',
            'is_required' => 'Обязательная',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplateOptions()
    {
        return $this->hasMany(TemplateOption::className(), ['option_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplates()
    {
        return $this->hasMany(Template::className(), ['id' => 'template_id'])->viaTable('template_option', ['option_id' => 'id']);
    }
}

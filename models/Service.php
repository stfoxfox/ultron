<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "service".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $price
 * @property integer $is_required
 *
 * @property TemplateService[] $templateServices
 * @property Template[] $templates
 */
class Service extends \yii\db\ActiveRecord
{
    /**
     * @return array
     */
    public static function getServices()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'title');
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'service';
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
    public function getTemplateServices()
    {
        return $this->hasMany(TemplateService::className(), ['service_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplates()
    {
        return $this->hasMany(Template::className(), ['id' => 'template_id'])->viaTable('template_service', ['service_id' => 'id']);
    }
}

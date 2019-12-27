<?php

namespace app\models;

use app\components\File;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "type".
 *
 * @property integer $id
 * @property string $title
 * @property string $short_title
 * @property string $description
 * @property string $alias
 * @property string $picture
 * @property integer $ordering
 * @property string $page_text
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $meta_title
 */
class Type extends \yii\db\ActiveRecord
{
    public $file;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'type';
    }

    /**
     * @return array
     */
    public static function getTypes()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'short_title');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'short_title', 'description', 'alias', 'ordering'], 'required'],
            [['description', 'meta_keywords', 'meta_description', 'meta_title'], 'string'],
            [['ordering'], 'integer'],
            [['title', 'short_title', 'alias'], 'string', 'max' => 255],
            [['picture'], 'string', 'max' => 64],
            [['page_text'], 'string'],
            [['file'], 'file', 'extensions' => 'png, jpg, jpeg, svg'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'short_title' => 'Сокр. название',
            'description' => 'Описание',
            'alias' => 'Ссылка',
            'picture' => 'Иконка',
            'displayImage' => 'Иконка',
            'file' => 'Иконка',
            'ordering' => 'Сортировка',
            'page_text' => 'Текст на странице',
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeValidate()
    {
        $this->file = UploadedFile::getInstance($this, 'file');
        if ($this->file === null) {
            $this->file = '';
        }
        return parent::beforeValidate();
    }

    /**
     * @return bool
     */
    public function beforeDelete()
    {
        //   File::unlink($this, 'picture');
        return true;
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (!empty($this->file)) {
            $this->picture = File::save($this, 'file');
            if ($this->picture === false) {
                $this->addError('image', 'Не удалось загрузить изображение.');
                return false;
            }
        }
        return parent::beforeSave($insert);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['id' => 'category_id'])
            ->viaTable('type_category', ['type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplates() {
        return $this->hasMany(Template::className(), ['type_id' => 'id']);
    }

    /**
     * @return string
     */
    public function getDisplayImage()
    {
        return File::img($this, 'picture', [40, 20], [
            'style' => 'width: 40px;height: 20px;',
        ]);
    }
}

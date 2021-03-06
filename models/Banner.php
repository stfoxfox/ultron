<?php

namespace app\models;

use app\components\File;
use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "banner".
 *
 * @property integer $id
 * @property string $picture
 * @property integer $ordering
 * @property string $url
 * @property string $title
 * @property string $subtitle
 * @property string $url_title
 */
class Banner extends \yii\db\ActiveRecord
{
    public $file;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'banner';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url'], 'required'],
            [['ordering'], 'integer'],
            [['title', 'subtitle', 'url_title', 'url'], 'string', 'max' => 255],
            [['file'], 'file', 'extensions' => 'png, jpg, jpeg'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '№',
            'picture' => 'Изображение',
            'title' => 'Заголовок',
            'subtitle' => 'Подзаголовок',
            'ordering' => 'Сортировка',
            'file' => 'Изображение',
            'displayImage' => 'Изображение',
            'url' => 'Ссылка',
            'url_title' => 'Название ссылки',
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
     * @return string
     */
    public function getDisplayImage()
    {
        return File::img($this, 'picture', [40, 20]);
    }
}

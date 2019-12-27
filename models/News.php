<?php

namespace app\models;

use app\components\File;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "news".
 *
 * @property integer $id
 * @property string $title
 * @property string $picture
 * @property string $short_text
 * @property string $full_text
 * @property string $created_at
 * @property integer $is_published
 * @property string $file
 * @property string $meta_description
 * @property string $meta_keywords
 */
class News extends CommonModel
{
    public $file;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'content', 'content_short'], 'required'],
            [['title', 'picture'], 'string', 'max' => 255],
            [['content_short'], 'string', 'max' => 65000],
            [['content'], 'string', 'max' => 65000],
            [['meta_keywords', 'meta_description'], 'string'],
            [['file'], 'file', 'extensions' => 'png, jpg, jpeg'],
        ];
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
    public function beforeValidate()
    {
        $this->file = UploadedFile::getInstance($this, 'file');
        if ($this->file === null) {
            $this->file = '';
        }
        return parent::beforeValidate();
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
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '№',
            'title' => 'Заголовок',
            'picture' => 'Изображение',
            'displayImage' => 'Изображение',
            'file' => 'Изображение',
            'content_short' => 'Сокращенный текст',
            'content' => 'Полный текст',
            'created_at' => 'Дата',
        ];
    }

    /**
     * @return string
     */
    public function getDisplayImage()
    {
        return File::img($this, 'picture', [40, 20]);
    }

    public function getAvailableTags() {
        return [
            'title',
            'keywords',
            'description',
            'content_short'
        ];
    }
}

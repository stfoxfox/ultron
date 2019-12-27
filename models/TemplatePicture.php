<?php

namespace app\models;

use app\components\File;
use Yii;

/**
 * This is the model class for table "template_picture".
 *
 * @property integer $id
 * @property integer $template_id
 * @property string $original_name
 * @property string $file_name
 * @property integer $size
 * @property string $created_at
 */
class TemplatePicture extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'template_picture';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['template_id', 'original_name', 'file_name', 'size'], 'required'],
            [['template_id', 'size'], 'integer'],
            [['created_at'], 'safe'],
            [['original_name'], 'string', 'max' => 255],
            [['file_name'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'template_id' => 'Template ID',
            'original_name' => 'Original Name',
            'file_name' => 'File Name',
            'size' => 'Size',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplate()
    {
        return $this->hasOne(Template::className(), ['id' => 'template_id']);
    }
}

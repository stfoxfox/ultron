<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "download".
 *
 * @property integer $id
 * @property integer $template_id
 * @property integer $template_file_id
 * @property integer $user_id
 * @property string $user_email
 * @property string $created_at
 */
class Download extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'download';
    }

    /**
     * TODO: ПЕРЕПИСАТЬ В ОДИН ЗАПРОС
     *
     * @param $userId
     * @return bool
     */
    public static function getNewVersionsCount($userId)
    {
        /** @var Download $models */
        $models = Download::find()
            ->where(['user_id' => $userId])
            ->groupBy(['template_id'])
            ->all();
        $totalCount = 0;
        foreach ($models as $model) {
            $totalCount += self::getNewVersionCount($userId, $model->template_id);
        }
        return $totalCount;
    }

    /**
     * TODO: ПЕРЕПИСАТЬ В ОДИН ЗАПРОС
     *
     * @param $userId
     * @param $templateId
     * @return int
     */
    public static function getNewVersionCount($userId, $templateId)
    {
        $lastDownloaded = (int)self::find()->where([
            'user_id' => $userId,
            'template_id' => $templateId,
        ])->max('template_file_id');

        return TemplateFile::find()->where(['AND',
            ['=', 'template_id', $templateId],
            ['>', 'id', $lastDownloaded],
        ])->count();
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
            'id' => 'ID',
            'template_file_id' => 'Template File ID',
            'user_id' => 'User ID',
            'user_email' => 'User Email',
            'created_at' => 'Created At',
        ];
    }
}

<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\HtmlPurifier;

/**
 * This is the model class for table "comment".
 *
 * @property integer $id
 * @property integer $template_id
 * @property integer $user_id
 * @property string $name
 * @property string $email
 * @property string $message
 * @property string $answer
 * @property integer $score
 * @property integer $is_published
 * @property string $created_at
 * @property integer $is_admin_viewed
 *
 * @property User $user
 * @property Template $template
 */
class Comment extends \yii\db\ActiveRecord
{
    const SCENARIO_ADMIN = 'admin';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'message'], 'required'],
            [['score'], 'in', 'range' => [1, 2, 3, 4, 5]],
            [['message'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['email'], 'string', 'max' => 128],
            [['email'], 'email'],
            [['is_published', 'is_admin_viewed'], 'boolean'],
            ['answer', 'filter', 'filter' => function () {
                return HtmlPurifier::process($this->answer);
            }],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_DEFAULT => ['name', 'message', 'score', 'email'],
            self::SCENARIO_ADMIN => ['answer', 'message', 'is_published'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '№',
            'template_id' => 'Шаблон',
            'user_id' => 'Пользователь',
            'name' => 'Имя',
            'email' => 'E-mail',
            'message' => 'Комментарий',
            'answer' => 'Ответ',
            'score' => 'Оценка',
            'is_published' => 'Опубликован',
            'created_at' => 'Дата',
        ];
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $avg = self::find()->where([
            'template_id' => $this->template_id,
            'is_published' => true,
        ])->average('score');

        Template::updateAll(['rating' => $avg], ['id' => $this->template_id]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplate()
    {
        return $this->hasOne(Template::className(), ['id' => 'template_id']);
    }

    /**
     * @return string
     */
    public function getDisplayName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getScorePercent()
    {
        return (int)$this->score * 25;
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'updatedAtAttribute' => false,
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @return int|string
     */
    public static function getNewCount()
    {
        return self::find()->where([
            'is_admin_viewed' => false,
        ])->count();
    }

    public static function allCommentsViewed()
    {
        Comment::updateAll([
            'is_admin_viewed' => true
        ]);
    }
}

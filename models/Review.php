<?php

namespace app\models;


use app\models\queries\ReviewModelQuery;
use app\models\queries\TemplateNoticeQuery;
use yii\db\ActiveRecord;
use vova07\comments\Module as CommentModule;

/**
 * Class Review
 * @package app\models
 *
 * @property integer $is_admin_viewed
 *
 * @property Template $template
 * @property User $author
 */
class Review extends \vova07\comments\models\frontend\Comment
{
    const EVENT_SEND_MESSAGES = 'event_send_messages';
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 2;

    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $this->on(self::EVENT_SEND_MESSAGES, [$this, 'onSendMessages']);
    }

    public static function tableName()
    {
        return '{{%review}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // Require
            ['content', 'required'],
            // Parent ID
            [
                'parent_id',
                'exist',
                'targetAttribute' => 'id',
                'filter' => ['model_id' => $this->model_id, 'model_class' => $this->model_class]
            ],
            // Model class
            ['model_class', 'exist', 'targetClass' => ReviewsModel::class, 'targetAttribute' => 'id'],
            // Model
            ['model_id', 'validateModelId'],
            // Content
            ['content', 'string'],
            [['is_admin_viewed'], 'integer'],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::class, ['id' => 'author_id']);
    }

    /**
     * @inheritdoc
     */
    public function validateModelId($attribute, $params)
    {
        /** @var ActiveRecord $class */
        $class = ReviewsModel::findIdentity($this->model_class);

        if ($class === null) {
            $this->addError($attribute, CommentModule::t('comments', 'ERROR_MSG_INVALID_MODEL_ID'));
        } else {
            $model = $class->name;
            if ($model::find()->where(['id' => $this->model_id]) === false) {
                $this->addError($attribute, CommentModule::t('comments', 'ERROR_MSG_INVALID_MODEL_ID'));
            }
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClass()
    {
        return $this->hasOne(ReviewsModel::class, ['id' => 'model_class']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModel()
    {
        /** @var ActiveRecord $class */
        $class = ReviewsModel::find()->where(['id' => $this->model_class])->one();
        $model = $class->name;
        return $this->hasOne($model::className(), ['id' => 'model_id']);
    }

    public function getTemplate()
    {
        $review = self::find()
            ->innerJoinWith([
                'class' => function (ReviewModelQuery $query) {
                    $query->template();
                }
            ])
            ->one();
        if (!$review)
            return;
        return $this->hasOne(Template::class, ['id' => 'model_id']);

    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if ($insert) {
            $this->trigger(self::EVENT_SEND_MESSAGES);

            $templateNotice = TemplateNotice::findOne([
                'user_id' => \Yii::$app->getUser()->getId(),
                'template_id' => $this->template->id
            ]);
            if (!$templateNotice) {
                $templateNotice = new TemplateNotice();
                $templateNotice->user_id = \Yii::$app->getUser()->getId();
                $templateNotice->template_id = $this->template->id;
                $templateNotice->receive_flag = 1;
                $templateNotice->save();
            }
        }
    }

    public function onSendMessages($event)
    {
        // Отправляем уыедомления всем пользователям в этой теме
        $users = User::find()
            ->innerJoinWith([
                'templateNotices' => function (TemplateNoticeQuery $query) {
                    $query
                        ->receive()
                        ->andWhere([
                            TemplateNotice::tableName() . '.template_id' => $this->template->id
                        ])
                        ->andWhere(['<>', TemplateNotice::tableName() . '.user_id', \Yii::$app->getUser()->getId()]);
            }])
            ->andWhere([
                '<>', User::tableName().'.id', $this->template->user_id
            ])
            ->all();
        $users = $users ?: [];

        // отправляем вебмастеру
        $webmaster = User::findOne($this->template->user_id);
        $users = array_merge($users, [$webmaster]);

        \Yii::$app->mailer->receivedMessage($this->template, $users, $this->template->getHtmlLink());
    }

    public function isUserTemplateAuthor()
    {
        return $this->template->user_id == $this->author_id;
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

    public static function allReviewsViewed()
    {
        Review::updateAll([
            'is_admin_viewed' => true
        ]);
    }
}
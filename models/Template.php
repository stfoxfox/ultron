<?php

namespace app\models;

use app\components\File;
use app\components\Translit;
use app\components\TemplateImagesValidator;
use app\components\Url;
use app\models\queries\ReviewModelQuery;
use voskobovich\linker\LinkerBehavior;
use voskobovich\linker\updaters\ManyToManyUpdater;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\HtmlPurifier;
use yii\web\UploadedFile;

/**
 * This is the model class for table "template".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $demo_url
 * @property string $price
 * @property string $type_id
 * @property string $new_price
 * @property string $discount_date
 * @property string $discount_start_date
 * @property integer $is_free
 * @property string $description
 * @property string $rating
 * @property string $sales_count
 * @property string $features
 * @property string $version_history
 * @property string $created_at
 * @property string $label
 * @property string $moderate_status
 * @property string $is_deleted
 * @property string $alias
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $meta_title
 *
 * @property Comment[] $comments
 * @property Favorite[] $favorites
 * @property User $user
 * @property Type $type
 * @property TemplateService[] $templateServices
 * @property Service[] $services
 * @property Option[] $options
 * @property TemplateTag[] $templateTags
 * @property Tag[] $tags
 * @property Category[] $categories
 * @property TemplateFile[] $files
 * @property TemplateFile $latestFile
 * @property TemplatePicture[] $pictures
 * @property TemplatePicture $firstPicture
 * @property Meta $meta
 * @property Review[] $reviews
 * @property $commentsCount
 * @property $reviewsCount
 */
class Template extends CommonModel
{
    const ARTICLE_LENGTH = 7;

    const TYPE_ALL = 'all';
    const TYPE_MODX = 'modx';
    const TYPE_HTML = 'html5';
    const TYPE_PSD = 'photoshop';

    const LABEL_NOVELTY = 'novelty';
    const LABEL_HIT = 'hit';
    const LABEL_ACTION = 'action';

    const STATUS_AVAILABLE = 'available';
    const STATUS_PAUSED = 'paused';

    const MODERATE_STATUS_PENDING = 'pending';
    const MODERATE_STATUS_ALLOWED = 'allowed';
    const MODERATE_STATUS_REFUSED = 'refused';

    const ROUTE_INDEX = 'template';
    const ROUTE_VIEW = 'template';

    /** @var $file UploadedFile */
    public $file;
    /** @var $images []UploadedFile] */
    public $images = [];

    /** @var $discount_date_range string */
    public $discount_date_range;

    /**
     * @inheritdoc
     */
    public static function find()
    {
        return parent::find()->andWhere([
            'is_deleted' => 0,
        ]);
    }

    /**
     * @return array
     */
    public static function getTypes()
    {
        return [
            self::TYPE_MODX => 'MODX Revolution сборки',
            self::TYPE_HTML => 'HTML шаблоны',
            self::TYPE_PSD => 'PSD шаблоны',
        ];
    }

    /**
     * @return int|string
     */
    public static function getPendingCount()
    {
        return self::find()->where([
            'moderate_status' => self::MODERATE_STATUS_PENDING,
            'is_deleted' => false,
        ])->count();
    }

    /**
     * @param $label
     * @return mixed|null
     */
    public static function getLabelText($label)
    {
        $data = [
            self::LABEL_NOVELTY => 'Новинка',
            self::LABEL_ACTION => 'Скидка',
            self::LABEL_HIT => 'Хит',
        ];

        return $data[$label] ?? null;
    }

    /**
     * @return array
     */
    public static function getStatuses()
    {
        return [
            self::STATUS_AVAILABLE => 'Продается',
            self::STATUS_PAUSED => 'Приостановлен',
        ];
    }

    /**
     * @return array
     */
    public static function getModerateStatuses()
    {
        return [
            self::MODERATE_STATUS_PENDING => 'В обработке',
            self::MODERATE_STATUS_ALLOWED => 'Одобрен',
            self::MODERATE_STATUS_REFUSED => 'Отклонен',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'template';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'type_id', 'category_ids'], 'required'],
            ['price', 'required', 'when' => function () {
                return $this->is_free == 0;
            }, 'whenClient' => "function(){return $('#free_template').is(':checked') === false;}"],
            [['file'], 'required', 'when' => function () {
                return $this->isNewRecord;
            }, 'whenClient' => "function(){return " . ($this->isNewRecord ? 'true' : 'false') . ";}"],
            ['file', 'file',
                'extensions' => ['rar', 'zip'],
                'checkExtensionByMimeType' => false,
                'maxSize' => 150000000,
                'tooBig' => 'Файл не должен превышать 150 MB.',
            ],
            ['images', TemplateImagesValidator::className()],
            [['is_free', 'type_id'], 'integer'],
            [['price', 'new_price'], 'number'],
            [['discount_date'], 'filter', 'filter' => function () {
                if (empty($this->discount_date)) {
                    return null;
                }
                return date('Y-m-d', strtotime($this->discount_date));
            }],
            [['discount_start_date'], 'filter', 'filter' => function () {
                if (empty($this->discount_start_date)) {
                    return null;
                }
                return date('Y-m-d', strtotime($this->discount_start_date));
            }],
            [['description', 'features', 'version_history', 'alias'], 'string'],
            'meta' => [['meta_keywords', 'meta_description', 'meta_title'], 'string'],
            ['description', 'filter', 'filter' => function () {
                return HtmlPurifier::process($this->description);
            }],

            [['title', 'demo_url'], 'string', 'max' => 255],
            ['moderate_status', 'in', 'range' => array_keys(self::getModerateStatuses())],
            ['status', 'in', 'range' => array_keys(self::getStatuses())],
            [['category_ids', 'tag_ids', 'service_ids', 'option_ids'], 'each', 'rule' => ['integer']],
            [['new_price', 'price'], 'filter', 'filter' => function ($value) {
                if (!$this->is_free && $value > 0) {
                    return floatval($value);
                }
                return null;
            }],
            ['order', 'integer'],
            [ ['new_price'], 'compare', 'compareAttribute' => 'price', 'operator' => '<=', 'type' => 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function delete()
    {
        $this->is_deleted = true;
        $this->save(false, ['is_deleted']);
    }

    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        Comment::deleteAll(['template_id' => $this->id]);
        Favorite::deleteAll(['template_id' => $this->id]);
        TemplateCategory::deleteAll(['template_id' => $this->id]);

        return true;
    }

    /**
     * @inheritdoc
     */
    public function beforeValidate()
    {
        if (!$this->alias) {
            $this->alias = '-' . Translit::str2url(trim($this->title));
        }
        $this->setDateRange();
        $this->images = unserialize(\Yii::$app->session->get('uploadedFiles', serialize([])));
        return parent::beforeValidate();
    }

    /**
     * @param null $userId
     * @return bool
     */
    public function getIsAllowedToView($userId = null)
    {
        return $this->moderate_status == self::MODERATE_STATUS_ALLOWED && $this->status == self::STATUS_AVAILABLE;
    }

    /**
     * @param null $user
     * @return bool
     */
    public function getIsAllowedToDownload($user = null)
    {
        if ($this->is_free || \Yii::$app->user->id == $this->user_id) {
            return true;
        } else {
            if (\Yii::$app->user->isGuest) {
                return false;
            }
            $invoceTemplates = InvoiceTemplate::find()
                ->joinWith(['template', 'invoice'])
                ->andWhere([
                    'invoice.user_id' => $user->id,
                    'invoice.status' => Invoice::STATUS_PAID,
                ])
                ->asArray()
                ->all();
            foreach ($invoceTemplates as $item) {
                if ($this->id == $item['template_id']) {
                    return true;
                }
            }
            return false;
        }
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $this->updateAlias();
        $this->saveFile();
        $this->saveImages();
    }

    /**
     * Adds id before alias
     * @void
     * */
    public function updateAlias()
    {
        if (mb_substr($this->alias, 0, 1) == '-') {
            $this->alias = $this->id . '-' . Translit::str2url(trim($this->title));
	    $this->updateAttributes(['alias' => $this->alias]);
            //$this->save();
        }
    }

    private function saveFile()
    {
        if (!$this->file instanceof UploadedFile) {
            return;
        }

        $currentTemplateFile = TemplateFile::find()->andWhere(['template_id'=>$this->id])->one();

        $model = new TemplateFile();
        $model->file_name = File::uniqueName($this->file->extension);
        $model->original_name = $this->file->name;
        $model->size = $this->file->size;
        $model->template_id = $this->id;

        $path = File::rootPath($model->file_name, [], '@app/templates') . $model->file_name;
        if ($model->save(false)) {
            $this->file->saveAs($path);

            if($currentTemplateFile)
                $currentTemplateFile->delete();
        }
    }

    private function saveImages()
    {
        if (!is_array($this->images)) {
            return;
        }

        foreach ($this->images as $image) {
            if (!$image instanceof UploadedFile) {
                die('e2');
                continue;
            }

            $model = new TemplatePicture();
            $model->file_name = File::uniqueName($image->extension);
            $model->original_name = $image->name;
            $model->size = $image->size;
            $model->template_id = $this->id;

            $path = File::rootPath($model->file_name) . $model->file_name;
            if (copy($image->tempName, $path)) {
                $model->save(false);
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '№',
            'preview' => 'Превью',
            'user_id' => 'Пользователь',
            'title' => 'Название шаблона',
            'type_id' => 'Тип шаблона',
            'demo_url' => 'Ссылка на демо-версию',
            'price' => 'Цена',
            'new_price' => 'Новая цена',
            'discount_start_date' => 'Дата начала акции',
            'discount_date' => 'Дата окончания акции',
            'is_free' => 'Бесплатный шаблон',
            'description' => 'Текстовое описание',
            'created_at' => 'Добавлен',
            'images' => 'Загрузить до 4 изображений шаблона',
            'category_ids' => 'Категории шаблона',
            'tag_ids' => 'Теги',
            'file' => 'Загрузить архив шаблона',
            'displayStatus' => 'Статус',
            'displayModerateStatus' => 'Модерация',
            'sales_count' => 'Кол-во продаж',
            'displayArticle' => 'Акртикул',
            'features' => 'Возможности',
            'version_history' => 'История версий',
            'tags' => 'Теги',
            'categories' => 'Категории',
            'moderate_status' => 'Модерация',
            'status' => 'Статус',
            'option_ids' => 'Доп. опции',
            'service_ids' => 'Доп. услуги',
            'meta_description' => 'Метатег Description',
            'meta_keywords' => 'Метатег Keywords',
            'meta_title' => 'Тайтл страницы'
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
            [
                'class' => LinkerBehavior::className(),
                'relations' => [
                    'category_ids' => [
                        'categories',
                        'updater' => [
                            'class' => ManyToManyUpdater::className(),
                        ]
                    ],
                    'tag_ids' => [
                        'tags',
                        'updater' => [
                            'class' => ManyToManyUpdater::className(),
                        ]
                    ],
                    'option_ids' => [
                        'options',
                        'updater' => [
                            'class' => ManyToManyUpdater::className(),
                        ]
                    ],
                    'service_ids' => [
                        'services',
                        'updater' => [
                            'class' => ManyToManyUpdater::className(),
                        ]
                    ],
                ],
            ],
        ]);
    }

    public function setDateRange() {
//        $date = explode(' - ', $this->discount_date);
//        $this->discount_start_date = $date[0];
//        $this->discount_date = $date[1];
        $this->discount_start_date = date("Y-m-d", time());
    }

    public function beforeSave($insert)
    {
        return parent::beforeSave($insert);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFavorites()
    {
        return $this->hasMany(Favorite::className(), ['template_id' => 'id']);
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
    public function getType()
    {
        return $this->hasOne(Type::className(), ['id' => 'type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     *
     */
    public function getFiles()
    {
        return $this->hasMany(TemplateFile::className(), ['template_id' => 'id']);
    }

    /**
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getLatestFile()
    {
        return $this->getFiles()->orderBy(['id' => SORT_DESC])->one();
    }

    /**
     * @return \yii\db\ActiveQuery
     *
     */
    public function getPictures()
    {
        return $this->hasMany(TemplatePicture::className(), ['template_id' => 'id']);
    }

    /**
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getFirstPicture()
    {
        return $this->getPictures()->orderBy(['id' => SORT_DESC])->one();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServices()
    {
        return $this->hasMany(Service::className(), ['id' => 'service_id'])
            ->viaTable('template_service', ['template_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOptions()
    {
        return $this->hasMany(Option::className(), ['id' => 'option_id'])
            ->viaTable('template_option', ['template_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplateTags()
    {
        return $this->hasMany(TemplateTag::className(), ['template_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
            ->viaTable('template_tag', ['template_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['id' => 'category_id'])
            ->viaTable('template_category', ['template_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return Review::find()
            ->innerJoin(Template::tableName(), Template::tableName().'.id = '. Review::tableName().'.model_id')
            ->innerJoinWith([
                'class' => function(ReviewModelQuery $query)
                {
                    $query->template();
                }
            ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['template_id' => 'id']);
    }

    /**
     * @return string
     */
    public function getDisplayArticle()
    {
        return str_pad($this->id, self::ARTICLE_LENGTH, 0, STR_PAD_LEFT);
    }

    /**
     * @return int
     */
    public function getSalesCount()
    {
        return $this->sales_count;
    }

    /**
     * @return int
     */
    public function getRatingPercentage()
    {
        if ($this->rating == 0) {
            return 0;
        }
        return 5 / $this->rating * 100;
    }

    /**
     * @return int
     */
    public function getDiscountPercentage()
    {
        if ($this->new_price) {
            return round(($this->price - $this->new_price) / ($this->price / 100));
        } else {
            return 0;
        }
    }

    /**
     * @return int|string
     */
    public function getCommentsCount()
    {
        return Comment::find()->where([
            'template_id' => $this->id,
            'is_published' => true,
        ])->count();
    }

    public function getReviewsCount()
    {
        return Review::find()
            ->innerJoinWith([
                'class' => function(ReviewModelQuery $query)
                {
                    $query->template();
                }
            ])
            ->andWhere([
                Review::tableName().'.model_id' => $this->id,
                Review::tableName().'.status_id' => Review::STATUS_ACTIVE,
                Review::tableName().'.parent_id' => null
            ])
            ->count();
    }

    /**
     * @return bool
     */
    public function canComment()
    {
        if (\Yii::$app->user->isGuest) {
            return false;
        }

        $sql = "SELECT COUNT(*) FROM invoice_template it
                    LEFT JOIN invoice i ON i.id = it.invoice_id
                    WHERE i.status = :status 
                            AND i.user_id = :user_id 
                            AND it.template_id = :template_id";

        $isPaid = \Yii::$app->db->createCommand($sql, [
                ':status' => Invoice::STATUS_PAID,
                ':user_id' => \Yii::$app->user->id,
                ':template_id' => $this->id,
            ])->queryScalar() > 0;

        if (!$isPaid) {
            return false;
        }

        $sql = "SELECT COUNT(*) FROM comment WHERE template_id = :template_id AND user_id = :user_id";
        $hasComments = \Yii::$app->db->createCommand($sql, [
                ':user_id' => \Yii::$app->user->id,
                ':template_id' => $this->id,
            ])->queryScalar() > 0;

        return $hasComments == false;
    }

    /**
     * @return null|string
     */
    public function getDisplayCssLabel()
    {
        // если задан счетчик времени, то это акция
        if ($this->isDiscountPeriod()) {
            return self::LABEL_ACTION;
        }

        // если меньше 30 дней, то это новинка
        if (strtotime($this->created_at) > (time() - (60 * 60 * 24 * 30))) {
            return self::LABEL_NOVELTY;
        }

        // если продаж больше 100, то это хит
        if ($this->sales_count > 100) {
            return self::LABEL_HIT;
        }

        return null;
    }

    /**
     * @return mixed
     */
    public function getDisplayModerateStatus()
    {
        return self::getModerateStatuses()[$this->moderate_status] ?? null;
    }

    /**
     * @return mixed
     */
    public function getDisplayStatus()
    {
        return self::getStatuses()[$this->status] ?? null;
    }

    /**
     * @return bool
     */
    public function isDiscountPeriod()
    {
        if ($this->hasDiscountPeriod()) {
            return strtotime($this->discount_date) > time() && strtotime($this->discount_start_date) < time();
        }
        return false;
    }

    /**
     * @return boolean
     * */
    public function hasDiscountPeriod()
    {
        return $this->discount_date && $this->discount_start_date;
    }

    /**
     * @return string
     */
    public function getActualPrice()
    {
        if ($this->new_price != null) {
            if (!$this->isDiscountPeriod() && $this->hasDiscountPeriod()) {
                return $this->price;
            } else {
                return $this->new_price;
            }
        }
        return $this->price;
    }

    /**
     * @return string
     */
    public function getDisplayPicture()
    {
        return File::img($this->firstPicture, 'file_name', [60, 60]);
    }

    public function getAvailableTags() {
        return [
            'title',
            'type',
            'category',
            'tags',
            'price',
            'meta_title',
            'keywords',
            'description'
        ];
    }

    public function getHtmlLink()
    {
        return Url::to('@web/'.$this->alias.'.html', 'http');
    }
}
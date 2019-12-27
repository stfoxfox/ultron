<?php

namespace app\models;

use voskobovich\linker\LinkerBehavior;
use voskobovich\linker\updaters\ManyToManyUpdater;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tag".
 *
 * @property integer $id
 * @property string $title
 * @property integer $alias
 *
 * @property TemplateTag[] $templateTags
 * @property Template[] $templates
 * @property Category[] $categories
 */
class Tag extends \yii\db\ActiveRecord
{
    /**
     * @param array $categories
     * @return array
     */
    public static function getTags($categories = [])
    {
        if ($categories) {
            /** @var Category[] $categories */
            $categories = Category::find()->where([
                'id' => $categories,
            ])->all();

            $tags = [];
            foreach ($categories as $category) {
                foreach ($category->tags as $tag) {
                    $tags[$tag->id] = $tag->title;
                }
            }
        } else {
            $tags = ArrayHelper::map(self::find()->all(), 'id', 'title');
        }

        return $tags;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tag';
    }

    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            TemplateTag::deleteAll(['tag_id' => $this->id]);
            CategoryTag::deleteAll(['tag_id' => $this->id]);
            return true;
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'alias'], 'required'],
            [['title', 'alias'], 'string', 'max' => 32],
            [['category_ids'], 'each', 'rule' => ['integer']],
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
            'alias' => 'Ссылка',
            'category_ids' => 'Категории',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplateTags()
    {
        return $this->hasMany(TemplateTag::className(), ['tag_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            [
                'class' => LinkerBehavior::className(),
                'relations' => [
                    'category_ids' => [
                        'categories',
                        'updater' => [
                            'class' => ManyToManyUpdater::className(),
                        ]
                    ],
                ],
            ],
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['id' => 'category_id'])
            ->viaTable('category_tag', ['tag_id' => 'id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplates()
    {
        return $this->hasMany(Template::className(), ['id' => 'template_id'])
            ->viaTable('template_tag', ['tag_id' => 'id']);
    }
}

<?php

namespace app\models;

use voskobovich\linker\LinkerBehavior;
use voskobovich\linker\updaters\ManyToManyUpdater;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property string $title
 * @property integer $ordering
 * @property integer $alias
 * @property integer $parent_id
 * @property integer $is_published
 * @property string $page_text
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $meta_title
 * @property string $heading
 * @property string $description
 *
 * @property Template[] $templates
 * @property Category $parent
 * @property Category[] $children
 * @property Tag[] $tags
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @return array
     */
    public static function getCategories()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'title');
    }

    /**
     * @param null $exceptId
     * @return array
     */
    public static function getParents($exceptId = null)
    {
        $query = self::find()->where([
            'parent_id' => null,
        ]);

        if ($exceptId != null) {
            $query->andWhere(['!=', 'id', $exceptId]);
        }

        return ArrayHelper::map($query->all(), 'id', 'title');
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'alias', 'type_ids'], 'required'],
            [['ordering', 'parent_id', 'is_published'], 'integer'],
            [['title', 'alias'], 'string', 'max' => 255],
            [['page_text', 'meta_keywords', 'meta_description', 'meta_title', 'heading', 'description'], 'string'],
            [['type_ids'], 'each', 'rule' => ['integer']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            TemplateCategory::deleteAll(['category_id' => $this->id]);
            CategoryTag::deleteAll(['category_id' => $this->id]);
            foreach ($this->children as $child) {
                $child->delete();
            }
            return true;
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'ordering' => 'Сортировка',
            'alias' => 'Сылка',
            'type_ids' => 'Типы',
            'is_published' => 'Опубликована',
            'parent_id' => 'Род. категория',
            'page_text' => 'Текст на странице',
            'heading' => 'Заголовок',
            'description' => 'Описание',
        ];
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
                    'type_ids' => [
                        'types',
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
    public function getTypes()
    {
        return $this->hasMany(Type::className(), ['id' => 'type_id'])
            ->viaTable('type_category', ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
            ->viaTable('category_tag', ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplateCategories()
    {
        return $this->hasMany(TemplateCategory::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplates()
    {
        return $this->hasMany(Template::className(), ['id' => 'template_id'])
            ->viaTable('template_category', ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Category::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(Category::className(), ['parent_id' => 'id']);
    }

    /**
     * @return bool
     */
    public function getEnabledTemplatesCount()
    {
        return TemplateCategory::find()
                ->leftJoin('template as t', 'template_id = t.id')
                ->where([
                    'category_id' => $this->id,
                    'status' => Template::STATUS_AVAILABLE,
                    'moderate_status' => Template::MODERATE_STATUS_ALLOWED,
                    'is_deleted' => false,
                ])->count() > 0;
    }

    /**
     * @return bool
     */
    public function hasTemplates()
    {
        $children = $this->children;
        foreach ($children as $child) {
            if ($child->getEnabledTemplatesCount() > 0) {
                return true;
            }
        }
        return $this->getEnabledTemplatesCount();
    }
}

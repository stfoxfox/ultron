<?php

namespace app\models\search;

use app\components\Sort;
use app\models\Category;
use app\models\Tag;
use app\models\Template;
use app\models\Type;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use app\models\User;

/**
 * TemplateSearch represents the model behind the search form about `app\models\Template`.
 */
class TemplateSearch extends Template
{
    const WEBMASTER_PAGE_SIZE = 10000;
    const DEFAULT_PAGE_SIZE = 30;

    public $id;
    public $category;
    public $tag;
    public $type;
    public $author;
    public $categoryModel;

    private $_type = null;
    private $_categories = null;
    private $_tags = null;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'category', 'tag', 'author'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * @return array|null|Type
     */
    public function findType()
    {
        if ($this->_type === null && $this->type != null) {
            $this->_type = Type::find()->where([
                'alias' => $this->type,
            ])->one();
        }
        return $this->_type;
    }

    /**
     * @return array|Category[]
     */
    public function findAvailableCategories()
    {
        $type = $this->findType();
        if ($this->_categories === null) {
            if ($type) {
                $this->_categories = $type
                    ->getCategories()
                    ->select([
                        "`template`.`title`",
                        "`type`.`title`",
                        "`category`.*"
                    ])
                    ->innerJoinWith(['templates', 'types'])
                    ->andWhere(['parent_id' => null, 'is_published' => true])
                    ->andWhere(['`type`.`id`' => $type->id])
                    ->andWhere(['`template`.`type_id`' => $type->id])
                    ->groupBy('`category`.`id`')
                    ->all();
            } else {
                $this->_categories = Category::find()
                    ->andWhere(['parent_id' => null, 'is_published' => true])
                    ->all();
            }
        }
        return $this->_categories;
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public function findAvailableTags()
    {
        $query = Tag::find();
        if ($this->findType()) {
            $categoryIds = ArrayHelper::map($this->findAvailableCategories(), 'id', 'id');
            $query
//                ->innerJoin('category_tag ct', 'ct.tag_id = tag.id')
                ->innerJoinWith(['categories', 'templates'])
                ->where(['category_tag.category_id' => $categoryIds])
                ->andWhere(['template.type_id' => $this->findType()->id])
                ->andWhere(['template.moderate_status' => 'allowed']);
        } elseif ($this->category) {
            $category = Category::find()->where(['alias' => $this->category])->one();
            if ($category) {
                $query->leftJoin('category_tag ct', 'ct.tag_id = tag.id')
                    ->where(['ct.category_id' => [$category->id, $category->parent_id]]);
            }
        }
        return $query->all();
    }

    /**
     * Creates data provider instance with search query applied
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params = [])
    {
        /** @var ActiveQuery $query */
        $query = Template::find();
        $query->joinWith(['user']);
        $query->andFilterWhere(['.user_id' => $this->user_id]);
        $query->andFilterWhere([Template::tableName().'.moderate_status' => $this->moderate_status]);
        $query->andFilterWhere([Template::tableName().'.id' => $this->id]);
        $query->orderBy(['order' => SORT_ASC, 'created_at' => SORT_DESC]);

        // $sort = new Sort([
        //     'defaultOrder' => ['order' => SORT_DESC],
        //     'attributes' => [
        //         'created_at' => SORT_DESC,
        //     ],
        // ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            // 'sort' => $sort,
            'pagination' => [
                // 'pageSize' => \Yii::$app->user->identity->role == User::ROLE_WEBMASTER ? self::WEBMASTER_PAGE_SIZE : self::DEFAULT_PAGE_SIZE,
                'pageSize' => self::DEFAULT_PAGE_SIZE,
            ],
        ]);

        $this->load($params, "");

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if ($this->tag) {
            $query->joinWith('tags');
            $query->andFilterWhere(['tag.alias' => $this->tag]);
        }

        $query->andFilterWhere(['user.username' => $this->author]);

        if ($this->category) {
            $query->joinWith('categories');
            /** @var Category $category */
            if($category = Category::find()->where(['alias' => $this->category])->one()){
                $this->categoryModel = $category;
            if ($category->parent_id == null) {
                $children = ArrayHelper::map($category->children, 'id', 'id');
                $query->andWhere(['category.id' => ArrayHelper::merge([$category->id], $children)]);
            } else {
                $query->andWhere(['category.id' => $category->id]);
            }
            }
        }
        $query->groupBy(Template::tableName().'.id');

        if ($this->findType()) {
            $query->andWhere(['type_id' => $this->findType()->id]);
        }

        return $dataProvider;
    }

    public function getAllCategories($templates)
    {
        return Category::find()
            ->innerJoinWith([
                'templates' => function(ActiveQuery $query) use($templates)
                {
                    $query->andWhere([
                        Template::tableName().'.id' => ArrayHelper::getColumn($templates, 'id')
                    ]);
                }
            ])
            ->all();
    }

    public function getAllTags($templates)
    {
        return Tag::find()
            ->innerJoinWith([
                'templates' => function(ActiveQuery $query) use($templates)
                {
                    $query->andWhere([
                        Template::tableName().'.id' => ArrayHelper::getColumn($templates, 'id')
                    ]);
                }
            ])
            ->all();
    }

}

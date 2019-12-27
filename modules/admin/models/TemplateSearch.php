<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Template;
use yii\db\Expression;

/**
 * TemplateSearch represents the model behind the search form about `app\models\Template`.
 */
class TemplateSearch extends Template
{
    public $searchArticle;
    public $searchUsername;
    public $searchStatus;
    public $searchType;
    public $searchModerateStatus;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['searchArticle', 'searchType', 'searchStatus', 'searchModerateStatus', 'sales_count',
                'searchUsername', 'title', 'created_at', 'status', 'price', 'discount_date', 'new_price',
                'moderate_status', 'price'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = TemplateSearch::find();
        $query->joinWith(['user','type']);
        $query->andFilterWhere(['user_id' => $this->user_id]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['order' => SORT_ASC],
                'attributes' => [
                    'created_at',
                    'id',
                    'searchArticle' => [
                        'asc' => ['id' => SORT_ASC],
                        'desc' => ['id' => SORT_DESC],
                    ],
                    'title',
                    'searchUsername' => [
                        'asc' => ['status' => SORT_ASC],
                        'desc' => ['status' => SORT_DESC],
                    ],
                    'searchStatus' => [
                        'asc' => ['status' => SORT_ASC],
                        'desc' => ['status' => SORT_DESC],
                    ],
                    'searchType' => [
                        'asc' => ['type.title' => SORT_ASC],
                        'desc' => ['type.title' => SORT_DESC],
                    ],
                    'searchModerateStatus' => [
                        'asc' => ['moderate_status' => SORT_ASC],
                        'desc' => ['moderate_status' => SORT_DESC],
                    ],
                    'sales_count',
                    'price',
                    'new_price',
                    'discount_date',
                    'order'
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['AND',
            ['LIKE', 'template.id', $this->searchArticle],
            ['LIKE', 'template.title', $this->title],
            ['LIKE', 'user.username', $this->searchUsername],
            ['=', new Expression('DATE(template.created_at)'), $this->created_at],
            ['>=', 'template.price', $this->price],
            ['>=', 'template.new_price', $this->new_price],
            ['=', new Expression('DATE(discount_date)'), $this->discount_date],
            ['>=', 'template.sales_count', $this->sales_count],
            ['=', 'template.status', $this->searchStatus],
            ['=', 'template.moderate_status', $this->searchModerateStatus],
            ['=', 'template.type_id', $this->searchType],
        ]);

        return $dataProvider;
    }
}

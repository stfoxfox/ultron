<?php

namespace app\modules\admin\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Payout;
use yii\db\Expression;

/**
 * PayoutSearch represents the model behind the search form about `app\models\Payout`.
 */
class PayoutSearch extends Payout
{
    public $searchDisplayNumber;
    public $searchWebmasterUsername;

    public $sumOfPayout;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['searchDisplayNumber', 'searchWebmasterUsername', 'created_at', 'sum'], 'safe'],
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
        $query = PayoutSearch::find()
            ->joinWith(['user']);

        $query->andFilterWhere([
            'user_id' => $this->user_id,
        ]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
                'attributes' => [
                    'id',
                    'searchDisplayNumber' => [
                        'asc' => ['id' => SORT_ASC],
                        'desc' => ['id' => SORT_DESC],
                    ],
                    'searchWebmasterUsername' => [
                        'asc' => ['user.username' => SORT_ASC],
                        'desc' => ['user.username' => SORT_DESC],
                    ],
                    'created_at',
                    'sum',
                ],
            ],
        ]);

        $this->load($params);
        $date = explode(' - ', $this['created_at']);
//        var_dump($date);die;
        $start = $date[0] ?? null;
        $end = $date[1] ?? null;
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['AND',
            ['LIKE', 'payout.id', $this->searchDisplayNumber],
            ['LIKE', 'user.username', $this->searchWebmasterUsername],
//            ['=', new Expression('DATE(payout.created_at)'), $this->created_at],
            ['between', new Expression('DATE(payout.created_at)'), "$start", "$end"],
            ['>=', 'sum', $this->sum],
        ]);

        $this->sumOfPayout = $query->sum('sum');

        return $dataProvider;
    }
}

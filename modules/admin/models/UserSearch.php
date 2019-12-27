<?php

namespace app\modules\admin\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;
use yii\db\Expression;

/**
 * UserSearch represents the model behind the search form about `app\models\User`.
 */
class UserSearch extends User
{
    public $goodsCount;
    public $salesCount;
    public $payoutSum;
    public $holdSum;
    public $earnedSum;

    /**
     * @param $role
     * @return int|string
     */
    public static function getPendingCount($role)
    {
        return self::find()->where([
            'role' => $role,
            'status' => self::STATUS_PENDING,
        ])->count();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'username', 'email', 'created_at', 'status', 'purchases_count', 'goodsCount',
                'salesCount', 'payoutSum', 'holdSum', 'earnedSum'], 'safe', 'on' => 'search'],
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
        $query = UserSearch::find();
        $query->andFilterWhere(['role' => $this->role]);
        $query->select(['user.*']);

        if ($this->role === self::ROLE_WEBMASTER) {
            //$query->joinWith(['templates']);
            //$query->andWhere(['IS', 'template.id', null]);
            $query->addSelect([
                // кол-во товаров
                '(SELECT COUNT(*) FROM template WHERE user_id = user.id AND template.is_deleted = 0) as goodsCount',
                '(SELECT SUM(sum) - COALESCE((SELECT SUM(sum) FROM payout WHERE user_id = user.id), 0) FROM income WHERE user_id = user.id) as totalIncome',
                '(SELECT SUM(sum) FROM income WHERE user_id = user.id AND income.created_at > (NOW() - INTERVAL 5 MINUTE)) as holdIncome',
                '(SELECT SUM(sum) - COALESCE((SELECT SUM(sum) FROM payout WHERE user_id = user.id), 0)
                    FROM income WHERE user_id = user.id AND income.created_at <= (NOW() - INTERVAL 5 MINUTE)) as availableIncome',
            ]);
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['user.id' => SORT_DESC],
                'attributes' => [
                    'user.id',
                    'username',
                    'email',
                    'created_at',
                    'status',
                    'purchases_count',
                    'goodsCount',
                    'salesCount',
                    'payoutSum',
                    'totalIncome',
                    'holdIncome',
                    'availableIncome',
                    'sales_count',
                    'earnedSum',
                    'displayStatus' => [
                        'asc' => ['status' => SORT_ASC],
                        'desc' => ['status' => SORT_DESC],
                    ],
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
            ['=', 'user.id', $this->id],
            ['LIKE', 'user.username', $this->username],
            ['LIKE', 'user.email', $this->email],
            ['=', 'user.status', $this->status],
            ['=', new Expression('DATE(user.created_at)'), $this->created_at],
            ['>=', 'user.purchases_count', $this->purchases_count],
        ]);

        if ($this->goodsCount != null) {
            $query->having('goodsCount = :goodsCount', [
                ':goodsCount' => $this->goodsCount,
            ]);
        }

        return $dataProvider;
    }
}

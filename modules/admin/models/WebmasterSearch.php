<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;
use yii\db\Expression;

/**
 * WebmasterSearch represents the model behind the search form about `app\models\Webmaster`.
 */
class WebmasterSearch extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'username', 'email', 'created_at', 'status', 'purchases_count'], 'safe', 'on' => 'search'],
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
        $query = User::find();
        $query->orderBy(['id' => SORT_DESC]);
        $query->andFilterWhere(['role' => $this->role]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['AND',
            ['=', 'id', $this->id],
            ['LIKE', 'username', $this->username],
            ['LIKE', 'email', $this->email],
            ['=', 'status', $this->status],
            ['=', new Expression('DATE(created_at)'), $this->created_at],
            ['>=', 'purchases_count', $this->purchases_count],
        ]);

        return $dataProvider;
    }
}
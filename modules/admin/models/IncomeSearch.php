<?php

namespace app\modules\admin\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Income;
use yii\data\ArrayDataProvider;
use yii\db\Expression;

/**
 * IncomeSearch represents the model behind the search form about `app\models\Income`.
 */
class IncomeSearch extends Income
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
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
        $query = IncomeSearch::find();
        $query->joinWith(['user']);
        $query->andWhere(['user.role' => User::ROLE_WEBMASTER]);
        $query->groupBy(['user_id']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
            ],
        ]);

        $this->load($params);

        $data = $dataProvider->getModels();
        $filteredData = [];
        foreach ($data as $model){
            if($model->user->holdIncome || $model->user->availableIncome){
                $filteredData[] = $model;
            }
        }
        $dataProvider = new ArrayDataProvider([
            'allModels' => $filteredData,
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        return $dataProvider;
    }
}

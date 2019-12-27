<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Paymaster;

/**
 * PaymasterSearch represents the model behind the search form about `app\models\Paymaster`.
 */
class PaymasterSearch extends Paymaster
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['LMI_SYS_PAYMENT_ID', 'LMI_PAYMENT_NO'], 'integer'],
            [['LMI_SYS_PAYMENT_DATE', 'LMI_CURRENCY', 'LMI_PAID_CURRENCY', 'LMI_PAYMENT_METHOD', 'LMI_PAYMENT_DESC', 'LMI_HASH', 'LMI_PAYER_IDENTIFIER', 'LMI_PAYER_COUNTRY', 'LMI_PAYER_PASSPORT_COUNTRY', 'LMI_PAYER_IP_ADDRESS'], 'safe'],
            [['LMI_PAYMENT_AMOUNT', 'LMI_PAID_AMOUNT'], 'number'],
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
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Paymaster::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'LMI_SYS_PAYMENT_ID' => $this->LMI_SYS_PAYMENT_ID,
            'LMI_PAYMENT_NO' => $this->LMI_PAYMENT_NO,
            'LMI_SYS_PAYMENT_DATE' => $this->LMI_SYS_PAYMENT_DATE,
            'LMI_PAYMENT_AMOUNT' => $this->LMI_PAYMENT_AMOUNT,
            'LMI_PAID_AMOUNT' => $this->LMI_PAID_AMOUNT,
        ]);

        $query->andFilterWhere(['like', 'LMI_CURRENCY', $this->LMI_CURRENCY])
            ->andFilterWhere(['like', 'LMI_PAID_CURRENCY', $this->LMI_PAID_CURRENCY])
            ->andFilterWhere(['like', 'LMI_PAYMENT_METHOD', $this->LMI_PAYMENT_METHOD])
            ->andFilterWhere(['like', 'LMI_PAYMENT_DESC', $this->LMI_PAYMENT_DESC])
            ->andFilterWhere(['like', 'LMI_HASH', $this->LMI_HASH])
            ->andFilterWhere(['like', 'LMI_PAYER_IDENTIFIER', $this->LMI_PAYER_IDENTIFIER])
            ->andFilterWhere(['like', 'LMI_PAYER_COUNTRY', $this->LMI_PAYER_COUNTRY])
            ->andFilterWhere(['like', 'LMI_PAYER_PASSPORT_COUNTRY', $this->LMI_PAYER_PASSPORT_COUNTRY])
            ->andFilterWhere(['like', 'LMI_PAYER_IP_ADDRESS', $this->LMI_PAYER_IP_ADDRESS]);

        return $dataProvider;
    }
}

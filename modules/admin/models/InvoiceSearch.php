<?php

namespace app\modules\admin\models;

use app\models\Invoice;
use app\models\InvoiceTemplate;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * InvoiceSearch represents the model behind the search form about `app\models\InvoiceTemplate`.
 */
class InvoiceSearch extends InvoiceTemplate
{
    public $userId; // invoice user id
    public $webmasterIncome;
    public $webmasterIncomePercent;
    public $serviceIncome;
    public $searchDisplayNumber;
    public $searchTemplateDisplayArticle;
    public $searchTemplateDisplayTitle;
    public $searchWebmasterUsername;
    public $searchCustomerUsername;
    public $searchInvoiceDate;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['searchDisplayNumber', 'searchTemplateDisplayArticle', 'searchTemplateDisplayTitle',
                'searchWebmasterUsername', 'searchCustomerUsername', 'status'], 'safe'],
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

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'searchDisplayNumber' => '№ платежа',
            'searchTemplateDisplayArticle' => 'Артикул',
            'searchTemplateDisplayTitle' => 'Название',
            'searchWebmasterUsername' => 'Вебмастер',
            'searchCustomerUsername' => 'Покупатель',
        ]);
    }

    /**
     * Creates data provider instance with search query applied
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = InvoiceTemplate::find();
        $query->joinWith(['template', 'invoice', 'income']);
        $query->where(['invoice.status' => Invoice::STATUS_PAID]);

        //$query->joinWith(['user', 'invoiceTemplates', 'invoiceTemplates.template.user as user2']);
        $query->andFilterWhere(['template.user_id' => $this->userId]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
//                'attributes' => [
//                    'invoice.id',
//                    'displayNumber' => [
//                        'asc' => ['invoice.id' => SORT_ASC],
//                        'desc' => ['invoice.id' => SORT_DESC],
//                    ],
//                    'searchDisplayNumber' => [
//                        'asc' => ['invoice.id' => SORT_ASC],
//                        'desc' => ['invoice.id' => SORT_DESC],
//                    ],
//                    'template.displayArticle' => [
//                        'asc' => ['template.id' => SORT_ASC],
//                        'desc' => ['template.id' => SORT_DESC],
//                    ],
//                    'searchTemplateDisplayArticle' => [
//                        'asc' => ['template.id' => SORT_ASC],
//                        'desc' => ['template.id' => SORT_DESC],
//                    ],
//                    'searchTemplateDisplayTitle' => [
//                        'asc' => ['template.title' => SORT_ASC],
//                        'desc' => ['template.title' => SORT_DESC],
//                    ],
//                    'template.title',
//                    'searchWebmasterUsername' => [
//                        'asc' => ['user.username' => SORT_ASC],
//                        'desc' => ['user.username' => SORT_DESC],
//                    ],
//                    'searchCustomerUsername' => [
//                        'asc' => ['user2.username' => SORT_ASC],
//                        'desc' => ['user2.username' => SORT_DESC],
//                    ],
//                    'paid_at' => [
//                        'asc' => ['invoice.paid_at' => SORT_ASC],
//                        'desc' => ['invoice.paid_at' => SORT_DESC],
//                    ],
//                    'sum',
//                    'webmasterIncomePercent',
//                    'webmasterIncome',
//                    'serviceIncome' => [
//                        'asc' => ['serviceIncome' => SORT_ASC],
//                        'desc' => ['serviceIncome' => SORT_DESC],
//                    ],
//                    'displayStatus' => [
//                        'asc' => ['status' => SORT_ASC],
//                        'desc' => ['status' => SORT_DESC],
//                    ],
//                ],
            ],
        ]);

        $this->load($params);
        if (isset($params['InvoiceSearch'])) {
            $date = explode(' - ', $params['InvoiceSearch']['searchInvoiceDate']);
            $start = $date[0];
            $end = $date[1];

            if (!$this->validate()) {
                // uncomment the following line if you do not want to return any records when validation fails
                // $query->where('0=1');
                return $dataProvider;
            }

            $query->andFilterWhere(['AND',
//            ['LIKE', 'invoice.id', $this->searchDisplayNumber],
//            ['LIKE', 'template.id', $this->searchTemplateDisplayArticle],
//            ['LIKE', 'template.title', $this->searchTemplateDisplayTitle],
//            ['LIKE', 'user2.username', $this->searchWebmasterUsername],
//            ['LIKE', 'user.username', $this->searchCustomerUsername],
//            ['=', new Expression('DATE(invoice.paid_at)'), $this->paid_at],
                ['between', new Expression('DATE(invoice.paid_at)'), $start, $end],
            ]);
        }
        return $dataProvider;
    }
}

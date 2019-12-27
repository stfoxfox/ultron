<?php

namespace app\controllers\user;

use app\models\Invoice;
use app\models\InvoiceTemplate;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;

/**
 * Class SaleController
 * @package app\controllers\user
 */
class SaleController extends UserCommonController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $query = InvoiceTemplate::find()
            ->joinWith([
                'invoice',
                'template',
                'income',
            ])
            ->andWhere([
                'template.user_id' => \Yii::$app->user->id,
		'invoice.status' => Invoice::STATUS_PAID
            ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
            ],
        ]);

        return $this->render('index', compact('dataProvider'));
    }
}

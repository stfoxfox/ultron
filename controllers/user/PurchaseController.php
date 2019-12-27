<?php

namespace app\controllers\user;

use app\models\Invoice;
use app\models\InvoiceTemplate;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;

/**
 * Class ProfileController
 * @package app\controllers\user
 */
class PurchaseController extends UserCommonController
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
            ->joinWith(['template', 'invoice'])
            ->andWhere([
                'invoice.user_id' => \Yii::$app->user->id,
                'invoice.status' => Invoice::STATUS_PAID,
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

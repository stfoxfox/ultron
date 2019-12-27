<?php

namespace app\controllers\user;

use app\models\Payout;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * Class PayoutController
 * @package app\controllers\user
 */
class PayoutController extends UserCommonController
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
                        'actions' => ['index', 'create'],
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
        $query = Payout::find()
            ->andWhere(['user_id' => \Yii::$app->user->id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
            ],
        ]);

        return $this->render('index', compact('dataProvider'));
    }

//    /**
//     * @return string
//     */
//    public function actionCreate()
//    {
//        $model = new Payout();
//        $model->sum = Payout::availableSum(\Yii::$app->user->id);
//        $model->user_id = \Yii::$app->user->id;
//        $model->load(\Yii::$app->request->post());
//
//        if (\Yii::$app->request->isAjax) {
//            \Yii::$app->response->format = Response::FORMAT_JSON;
//            return ActiveForm::validate($model);
//        }
//
//        if (\Yii::$app->request->isPost && $model->save()) {
//            $this->redirect(['index']);
//        }
//
//        return $this->render('create', compact('model'));
//    }
}

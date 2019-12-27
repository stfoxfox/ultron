<?php
namespace app\controllers;


use yii\web\Controller;

class SearchController extends Controller
{

    public function actionIndex()
    {
        $model = new \app\models\sphinx\Template();
        $search = \Yii::$app->getRequest()->get('search');
        $searchModelFull = $model->getSearchModel(["search" => $search]);
        $dataProviderFull = $searchModelFull->search(["search" => $search]);
        $searchModel = $model->getSearchModel(\Yii::$app->getRequest()->get());
        $dataProvider = $searchModel->search(\Yii::$app->getRequest()->get());

        return $this->render('index', compact(
            'searchModelFull',
            'dataProviderFull',
            'searchModel',
            'dataProvider',
            'search'
        ));
    }

}
<?php

namespace app\controllers;

use app\models\Meta;
use app\models\News;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Class NewsController
 * @package app\controllers
 */
class NewsController extends CommonController
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => News::find()->orderBy(['id' => SORT_DESC]),
        ]);

        return $this->render('index', compact('dataProvider'));
    }

    /** 
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = News::find()->where(['id' => $id])->one();
        if (!$model) {
            throw new NotFoundHttpException();
        }

        $meta = Meta::getMeta($this->route, $model);
        $this->setMeta($meta);

        return $this->render('view', compact('model'));
    }
}

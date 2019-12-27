<?php

namespace app\controllers;

use app\models\Meta;
use app\models\Page;
use yii\web\NotFoundHttpException;

/**
 * Class PageController
 * @package app\controllers
 */
class PageController extends CommonController
{
    /**
     * @param $alias
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($alias)
    {
        $model = Page::find()->where(['alias' => $alias])->one();
        if (!$model) {
            throw new NotFoundHttpException();
        }

        $meta = Meta::getMeta($this->route, $model);
        $this->setMeta($meta);

        return $this->render('view', compact('model'));
    }
}

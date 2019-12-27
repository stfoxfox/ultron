<?php

namespace app\controllers;

use app\models\Favorite;
use app\models\Template;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Class FavoriteController
 * @package app\controllers
 */
class FavoriteController extends CommonController
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $models = Favorite::find()
            ->joinWith(['template'])
            ->where([
                'favorite.user_id' => \Yii::$app->user->id,
                'template.moderate_status' => Template::MODERATE_STATUS_ALLOWED,
            ])
            ->limit(500)
            ->orderBy(['id' => SORT_DESC])
            ->all();

        return $this->render('index', compact('models'));
    }

    /**
     * @param $id
     * @throws NotFoundHttpException
     */
    public function actionToggle($id)
    {
        $template = Template::findOne($id);
        if (!$template) {
            throw new NotFoundHttpException();
        }

        $params = [
            'user_id' => \Yii::$app->user->id,
            'template_id' => $template->id,
        ];

        if (Favorite::isExists(\Yii::$app->user->id, $template->id)) {
            Favorite::deleteAll($params);
        } else {
            (new Favorite($params))->save(false);
        }
    }
}
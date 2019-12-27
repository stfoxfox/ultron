<?php

namespace app\controllers;

use app\models\Comment;
use app\models\Template;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\Response;

/**
 * Class CommentController
 * @package app\controllers
 */
class CommentController extends Controller
{
    /**
     * @param $id
     * @return array
     * @throws ForbiddenHttpException
     */
    public function actionCreate($id)
    {
        $template = Template::findOne($id);
        if (!$template->canComment()) {
            throw new ForbiddenHttpException();
        }

        $model = new Comment([
            'template_id' => $template->id,
            'user_id' => \Yii::$app->user->id,
        ]);
        $model->load($_POST);

        \Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'status' => $model->save(),
        ];
    }
}

<?php

namespace app\controllers;


use app\models\AppealForm;
use app\models\ReviewForm;
use app\models\Template;
use app\models\TemplateNotice;
use Yii;
use app\models\Review;
use yii\db\Exception;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use vova07\comments\Module as CommentModule;
use yii\widgets\ActiveForm;

class ReviewController extends Controller
{

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex($template_id)
    {
        $model = Template::findOne($template_id);
        if (!$model) {
            throw new NotFoundHttpException();
        }
        return $this->renderAjax('index', [
            'model' => $model
        ]);
    }

    public function actionTemplateNoticeToggle($template_id)
    {
        $receive_flag = Yii::$app->getRequest()->post('receive_flag');
        if($receive_flag != null){
            $templateNotice = TemplateNotice::getByTemplateForUser($template_id, \Yii::$app->getUser()->getId());
            $templateNotice = $templateNotice ?: new TemplateNotice([
                'user_id' => \Yii::$app->getUser()->getId(),
                'template_id' => $template_id
            ]);
            $templateNotice->receive_flag = $receive_flag;
            return $templateNotice->save();
        }
    }

    public function actionCreate()
    {
        $model = new Review(['scenario' => 'create']);
        $formModel = new ReviewForm();
        Yii::$app->response->format = Response::FORMAT_JSON;

        if ($formModel->load(Yii::$app->request->post())) {
            if ($formModel->validate()) {
                $model->setAttributes($formModel->getAttributes());

                $formModel->saveTemplateNotice();
                if ($model->save(false)) {
                    return $this->tree($model);
                } else {
                    Yii::$app->response->setStatusCode(500);
                    return CommentModule::t('comments', 'FRONTEND_FLASH_FAIL_CREATE');
                }
            } elseif (Yii::$app->request->isAjax) {
                Yii::$app->response->setStatusCode(400);
                return ActiveForm::validate($formModel);
            }
        } else {
            $formModel->load(Yii::$app->request->get());
            return $this->renderAjax('@app/widgets/review/views/_form', [
                'model' => $formModel
            ]);
        }
    }

    public function actionReply($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = new Review(['scenario' => 'create']);
        $parentModel = $this->findModel($id);
        $formModel = new ReviewForm($model);
        $formModel->parent_id = $parentModel->id;
        $formModel->model_class = $parentModel->model_class;
        $formModel->model_id = $parentModel->model_id;

        if ($formModel->load(Yii::$app->request->post())) {
            if ($formModel->validate()) {
                $model->setAttributes($formModel->getAttributes());
                if ($model->save(false)) {
                    return $this->tree($model);
                } else {
                    Yii::$app->response->setStatusCode(500);
                    return CommentModule::t('comments', 'FRONTEND_FLASH_FAIL_CREATE');
                }
            } elseif (Yii::$app->request->isAjax) {
                Yii::$app->response->setStatusCode(400);
                return ActiveForm::validate($formModel);
            }
        } else {
            return $this->renderAjax('@app/widgets/review/views/_form', [
                'model' => $formModel
            ]);
        }
    }

    public function actionAppeal($id)
    {
        $formModel = new AppealForm();
        $model = $this->findModel($id);
        $formModel->template_id = $id;
        Yii::$app->response->format = Response::FORMAT_JSON;

        if ($formModel->load(Yii::$app->request->post())) {
            if ($formModel->validate()) {
                $model->setAttributes($formModel->getAttributes());
                // send message
                $template = Template::findOne($model->model_id);
                if(!$template)
                    throw new Exception('Unknown template');
                Yii::$app->mailer->sendAppeal($formModel->content, $model, $template->getHtmlLink());
                return '';
            } elseif (Yii::$app->request->isAjax) {
                Yii::$app->response->setStatusCode(400);
                return ActiveForm::validate($formModel);
            }
        } else {
            return $this->renderAjax('@app/widgets/review/views/_appeal_form', [
                'model' => $formModel
            ]);
        }
    }

    /**
     * Update comment.
     *
     * @param integer $id Comment ID
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->setScenario('update');
        $formModel = new ReviewForm($model);
        $formModel->setAttributes($model->attributes);
        Yii::$app->response->format = Response::FORMAT_JSON;

        if ($formModel->load(Yii::$app->request->post())) {
            if ($formModel->validate()) {
                $model->setAttributes($formModel->getAttributes());
                if ($model->save(false)) {
                    return $this->tree($model);
                } else {
                    Yii::$app->response->setStatusCode(500);
                    return CommentModule::t('comments', 'FRONTEND_FLASH_FAIL_UPDATE');
                }
            } elseif (Yii::$app->request->isAjax) {
                Yii::$app->response->setStatusCode(400);
                return ActiveForm::validate($formModel);
            }
        } else {
            return $this->renderAjax('@app/widgets/review/views/_form', [
                'model' => $formModel
            ]);
        }
    }

    /**
     * Delete comment page.
     *
     * @param integer $id Comment ID
     *
     * @return string Review content
     */
    public function actionDelete($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if ($this->findModel($id)->deleteComment()) {
            return CommentModule::t('comments', 'FRONTEND_WIDGET_COMMENTS_DELETED_COMMENT_TEXT');
        } else {
            Yii::$app->response->setStatusCode(500);
            return CommentModule::t('comments', 'FRONTEND_FLASH_FAIL_DELETE');
        }
    }

    /**
     * Find model by ID.
     *
     * @param integer|array $id Comment ID
     *
     * @return Review Model
     *
     * @throws HttpException 404 error if comment not found
     */
    protected function findModel($id)
    {
        /** @var Review $model */
        $model = Review::findOne($id);

        if ($model !== null) {
            return $model;
        } else {
            throw new HttpException(404, CommentModule::t('comments', 'FRONTEND_FLASH_RECORD_NOT_FOUND'));
        }
    }

    /**
     * @param Review $model Review
     *
     * @return string Comments list
     */
    protected function tree($model)
    {
        $models = Review::getTree($model->model_id, $model->model_class);
        return $this->renderPartial('@app/widgets/review/views/_index_item', ['models' => $models, 'num' => 0]);
    }

}
<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\PayoutSearch;
use app\modules\admin\models\User;
use Yii;
use app\models\Payout;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * PayoutController implements the CRUD actions for Payout model.
 */
class PayoutController extends Controller
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
                        'allow' => true,
                        'matchCallback' => function () {
                            return Yii::$app->user->isAdmin;
                        },
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PayoutSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * @param $userId
     * @return array|string|Response
     * @throws NotFoundHttpException
     */
    public function actionCreate($userId)
    {
        $user = User::findOne($userId);
        if (!$user || $user->role !== User::ROLE_WEBMASTER) {
            throw new NotFoundHttpException();
        }

        $model = new Payout(['user_id' => $userId]);
        $model->load(Yii::$app->request->post());

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if (Yii::$app->request->isPost && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', compact('model', 'user'));
        }
    }

    /**
     * Deletes an existing Payout model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionDelete()
    {
        if ($post = Payout::validateDeleteForm()) {
            $id = $post['id'];
            $this->findModel($id)->delete();
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Payout model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Payout the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Payout::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

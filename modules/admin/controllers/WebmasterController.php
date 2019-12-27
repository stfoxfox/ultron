<?php

namespace app\modules\admin\controllers;

use app\models\User;
use app\modules\admin\models\InvoiceSearch;
use app\modules\admin\models\PayoutSearch;
use app\modules\admin\models\TemplateSearch;
use app\modules\admin\models\UserSearch;
use app\modules\admin\models\Webmaster;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WebmasterController implements the CRUD actions for Webmaster model.
 */
class WebmasterController extends Controller
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
     * Lists all Webmaster models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $searchModel->scenario = 'search';
        $searchModel->role = Webmaster::ROLE_WEBMASTER;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Webmaster model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $model,
            'templateDataProvider' => (new TemplateSearch(['user_id' => $model->id]))->search([]),
            'invoiceDataProvider' => (new InvoiceSearch(['userId' => $model->id]))->search([]),
            'payoutDataProvider' => (new PayoutSearch(['user_id' => $model->id]))->search([]),
        ]);
    }

    /**
     * Creates a new Webmaster model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Webmaster();
        $model->role = Webmaster::ROLE_WEBMASTER;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Webmaster model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            var_dump($model->attributes);die;
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Webmaster model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionDelete()
    {
        if ($post = User::validateDeleteForm()) {
            $id = $post['id'];
            $this->findModel($id)->delete();
        }
        return $this->redirect(['index']);
    }

    /**
     * @param $id
     * @return array|null|\yii\db\ActiveRecord
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        $model = Webmaster::find()->where(['id' => $id, 'role' => Webmaster::ROLE_WEBMASTER])->one();
        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

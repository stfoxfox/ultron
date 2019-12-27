<?php

namespace app\modules\admin\controllers;

use app\components\Sort;
use app\models\CommonModel;
use app\models\Invoice;
use app\models\InvoiceTemplate;
use app\modules\admin\models\User;
use Yii;
use app\modules\admin\models\UserSearch;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $searchModel->scenario = 'search';
        $searchModel->role = User::ROLE_USER;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = new Sort([
            'defaultOrder' => ['id' => SORT_DESC],
        ]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        $dataProvider = new ActiveDataProvider([
            'query' => InvoiceTemplate::find()->where([
                'invoice.user_id' => $model->id,
            ])->joinWith(['invoice', 'template', 'template.user']),
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
//                'attributes' => [
//                    'id',
//                    'created_at',
//                    'template.title' => [
//                        'asc' => ['template.title' => SORT_ASC],
//                        'desc' => ['template.title' => SORT_DESC],
//                    ],
//                    'template.displayArticle' => [
//                        'asc' => ['template.id' => SORT_ASC],
//                        'desc' => ['template.id' => SORT_DESC],
//                    ],
//                    'template.user.username' => [
//                        'asc' => ['user.username' => SORT_ASC],
//                        'desc' => ['user.username' => SORT_DESC],
//                    ],
//                    'template.actualPrice' => [
//                        'asc' => ['template.price' => SORT_ASC],
//                        'desc' => ['template.price' => SORT_DESC],
//                    ],
//                ],
            ],
        ]);

        return $this->render('view', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
        $model->role = User::ROLE_USER;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete()
    {
        if ($post = CommonModel::validateDeleteForm()) {
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
        $model = User::find()->where(['id' => $id, 'role' => User::ROLE_USER])->one();
        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

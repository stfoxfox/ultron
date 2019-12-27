<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\FavoriteTemplate;
use app\models\Template;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * FavoriteTemplateController implements the CRUD actions for FavoriteTempla model.
 */
class FavoriteTemplateController extends Controller
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
     * Lists all FavoriteTemplate models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider(['query' => FavoriteTemplate::find()]);
        
        $templates = ArrayHelper::map(Template::find()->all(), 'id', function($model) {
            return $model->displayArticle . " | " . $model->title;
        });

        $favoriteTemplate = new FavoriteTemplate();
        
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'favoriteTemplate' => $favoriteTemplate,
            'templates' => $templates,
        ]);
    }

    /**
     * Creates a new FavoriteTemplate model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new FavoriteTemplate();

        if (\Yii::$app->request->isAjax) {
            $model->load(Yii::$app->request->post());
            if ($model->save()) {
                echo Json::encode([
                    'error' => false, 
                    'displayArticle' => $model->template->displayArticle, 
                    'title' => $model->template->title
                ]);
            } else {
                echo Json::encode(["error" => true]);
            }
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        
        }
    }

    /**
     * Deletes an existing FavoriteTemplate model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the FavoriteTemplate model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FavoriteTemplate the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FavoriteTemplate::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

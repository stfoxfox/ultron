<?php

namespace app\controllers;

use app\components\File;
use app\models\Category;
use app\models\Download;
use app\models\Meta;
use app\models\search\TemplateSearch;
use app\models\Template;
use app\models\TemplateFile;
use app\models\Type;
use app\models\User;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Class TemplateController
 *
 * @package app\controllers
 */
class TemplateController extends CommonController
{

    public function beforeAction($action)
    {
        if ($action->id === 'index') {
            return Controller::beforeAction($action);
        }
        return parent::beforeAction($action);
    }

    public function actionIndex($type = null, $category = null)
    {
        $metaKeywords = $metaDescription = $metaTitle = $heading = $description = null;
        $page = (int) \Yii::$app->getRequest()->get('page', 1);

        $pageText = $typePageText = $categoryPageText = null;
        $typeModel = $categoryModel = null;
        if ($type) {
            $typeModel = Type::findOne([
                'alias' => $type
            ]);
            if ($typeModel) {
                $typePageText = $page === 1 ? $typeModel->page_text : null;
                $metaKeywords = $typeModel->meta_keywords;
                $metaDescription = $typeModel->meta_description;
                $metaTitle = $typeModel->meta_title;
            } elseif ($type !== 'all')
                throw new NotFoundHttpException();
        }
        if (!$category && !$typeModel)
            $category = $type;

        if ($category) {
            $categoryModel = Category::findOne([
                'alias' => $category
            ]);

            if ($categoryModel) {
                if ('all' === $type) {
                    if ($page === 1) {
                        $categoryPageText = $categoryModel->page_text;
                    }
                    if ($categoryModel->heading) {
                        $heading = $categoryModel->heading;
                    }
                    if ($categoryModel->description) {
                        $description = $categoryModel->description;
                    }
                }
                $metaKeywords = $categoryModel->meta_keywords;
                $metaDescription = $categoryModel->meta_description;
                $metaTitle = $categoryModel->meta_title;
            } elseif ($category !== 'all')
                throw new NotFoundHttpException();
        }

        $searchModel = new TemplateSearch();
        $searchModel->moderate_status = Template::MODERATE_STATUS_ALLOWED;
        $dataProvider = $searchModel->search(\Yii::$app->request->get());

        $meta = Meta::getMeta($this->route);
        $this->view->title = $metaTitle ?: $meta->getTitle();
        if ($metaKeywords)
            $this->view->registerMetaTag(['name' => 'keywords', 'content' => $metaKeywords], 'keywords');
        else
            $this->view->registerMetaTag(['name' => 'keywords', 'content' => $meta->getKeywords()], 'keywords');
        if ($metaDescription)
            $this->view->registerMetaTag(['name' => 'description', 'content' => $metaDescription], 'description');
        else
            $this->view->registerMetaTag(['name' => 'keywords', 'content' => $meta->getDescription()], 'keywords');

        $currentPage = \Yii::$app->getRequest()->get('page', 1);
        // $pageSize = \Yii::$app->user->identity->role == User::ROLE_WEBMASTER ? TemplateSearch::WEBMASTER_PAGE_SIZE : TemplateSearch::DEFAULT_PAGE_SIZE;
        $pages = ceil($dataProvider->getTotalCount() / TemplateSearch::DEFAULT_PAGE_SIZE);

    

        $heading = $heading ?: 'Все HTML шаблоны и готовые сайты';
        $description = $description ?: 'Создайте сайт на основе адаптивных шаблонов от Ultron';
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'pageText' => $pageText,
            'typePageText' => $typePageText,
            'categoryPageText' => $categoryPageText,
            'currentPage' => $currentPage,
            'pages' => $pages,
            'heading' => $heading,
            'description' => $description
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id = null)
    {
        $model = Template::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException();
        }

        $meta = Meta::getMeta($this->route, $model);
        $this->setMeta($meta);

        return $this->render('view', compact('model'));
    }

    /**
     * @param $id
     * @param null $fid
     * @return $this|string
     * @throws NotFoundHttpException
     */
    public function actionDownload($id, $fid = null)
    {
        /** @var Template $model */
        $model = Template::find()->where(['id' => $id])->one();
        if (!$model || !$model->getIsAllowedToDownload(\Yii::$app->user->identity)) {
            return $this->render('view', compact('model'));
        }

        /** @var $file TemplateFile */
        if ($fid) {
            $file = TemplateFile::find()->where(['id' => $fid, 'template_id' => $model->id])->one();
        } else {
            $file = $model->latestFile;
        }

        if (!$file) {
            throw new NotFoundHttpException();
        }

        $path = File::rootPath($file->file_name, [], '@app/templates') . $file->file_name;

        if (!file_exists($path)) {
            throw new NotFoundHttpException();
        }

        // todo: check access control...

        $download = new Download();
        $download->user_id = \Yii::$app->user->id;
        $download->template_id = $model->id;
        $download->template_file_id = $file->id;
        $download->save(false);

        return \Yii::$app->response->sendFile($path, $file->original_name);
    }
}

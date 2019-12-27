<?php

namespace app\controllers\user;

use app\components\File;
use app\models\Category;
use app\models\search\TemplateSearch;
use app\models\Tag;
use app\models\TemplateFile;
use app\models\TemplatePicture;
use app\widgets\categories\Categories;
use Yii;
use app\models\Template;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;

/**
 * Class ProfileController
 * @package app\controllers\user
 */
class TemplateController extends UserCommonController
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
                        'actions' => ['index', 'upload', 'update', 'purchase', 'upload-files', 'delete-picture', 'tags'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $model = new TemplateSearch([
            'user_id' => Yii::$app->user->id,
        ]);
        $dataProvider = $model->search(Yii::$app->request->get());
        return $this->render('index', compact('model', 'dataProvider'));
    }

    /**
     * @return string
     */
    public function actionUpload()
    {
        if (!Yii::$app->request->isPost) {
            Yii::$app->session->remove('uploadedFiles');
        }
	
        $model = new \app\models\user\Template();
        $model->loadDefaultValues(false);

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            $model->user_id = Yii::$app->user->id;
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Новый шаблон успешно загружен');
                return $this->redirect(['upload']);
            }
        }

        return $this->render('upload', compact('model'));
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        if (!Yii::$app->request->isPost) {
            Yii::$app->session->remove('uploadedFiles');
        }

        $model = \app\models\user\Template::findOne($id);
        if (!$model || $model->user_id != Yii::$app->user->id) {
            throw new NotFoundHttpException();
        }

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Изменения успешно сохранены');
                return $this->redirect(['update', 'id' => $id]);
            }
        }

        return $this->render('upload', compact('model'));
    }

    /**
     * @return string
     */
    public function actionUploadFiles()
    {
        // получить файл из $_FILES
        /** @var UploadedFile[] $file */
        $file = UploadedFile::getInstancesByName('Template[images]');
        if (count($file) == 0) {
            return json_encode(['false']);
        }

        // скопировать новый файл во временную директорию
        $tmpPath = Yii::getAlias('@webroot/storage/tmp');
        if (!file_exists($tmpPath)) {
            mkdir($tmpPath, 777, true);
        }

        $tmpName = $tmpPath . '/' . File::uniqueName($file[0]->getExtension());
        // переместить файл во временную директорию
        $file[0]->saveAs($tmpName);

        // изменить имя и путь временного файла для обработки в дальнейшем (при сохранении модели)
        $file[0]->tempName = $tmpName;

        // получим из сессии массив загруженных ранее файлов, что бы к ним добавить ещё один
        $files = unserialize(Yii::$app->session->get('uploadedFiles', serialize([])));
        // если файлов уже больше 4х, то удалим самый первый
        if (count($files) > 4) {
            $deleted = array_shift($files);
            if (file_exists($deleted->tempName)) {
                unlink($deleted->tempName);
            }
        }

        // запишем информацтию о файле в сессию пользователя для дальнейшего сохранения
        $files[] = $file[0];
        Yii::$app->session->set('uploadedFiles', serialize($files));
        return json_encode(['ok']);
    }

    /**
     * @return string
     */
    public function actionPurchase()
    {
        return $this->render('purchase');
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionDeletePicture()
    {
        $id = Yii::$app->request->post('id');
        $name = Yii::$app->request->post('name');

        if ($id) {
            $picture = TemplatePicture::findOne($id);
            if (!$picture || $picture->template->user_id !== Yii::$app->user->id) {
                throw new NotFoundHttpException();
            }

            $picturesCount = TemplatePicture::find()
                ->andWhere([
                    'template_id' => $picture->template_id
                ])
                ->count();
            if($picturesCount > 1)
                $picture->delete();
            else
                throw new \RuntimeException('Невозможно удалить последнее изображение');
        } elseif ($name) {
            $files = unserialize(Yii::$app->session->get('uploadedFiles', serialize([])));
            foreach ($files as $i => $file) {
                if ($file instanceof UploadedFile && $file->name == $name) {
                    unlink($file->tempName);
                    unset($files[$i]);
                }
            }
            Yii::$app->session->set('uploadedFiles', serialize($files));
        }
    }

    /**
     * @return string
     */
    public function actionTags()
    {
        $tags = Tag::getTags(Yii::$app->request->get('categories'));

        $tagOptions = [];
        $options = Html::renderSelectOptions(null, $tags, $tagOptions);

        Yii::$app->response->format = Response::FORMAT_JSON;
        return Json::encode($options);
    }

    /**
     * @param Template $template
     * @return string
     */
    public function getFilesJson(Template $template)
    {
        $pictures = [];
        if ($template->images) {
            /** @var UploadedFile $image */
            foreach ($template->images as $image) {
                $pictures[] = [
                    'name' => $image->name,
                    'size' => $image->size,
                    'type' => $image->type,
                    'file' => str_replace(Yii::getAlias('@webroot'), '', $image->tempName),
                    'data' => ['name' => $image->name]
                ];
            }
        } else {
            foreach ($template->pictures as $picture) {
                $pictures[] = [
                    'name' => $picture->original_name,
                    'size' => $picture->size,
                    'type' => 'image/png',
                    'file' => File::src($picture, 'file_name', [155, 145]),
                    'data' => ['id' => $picture->id]
                ];
            }
        }

        return Json::encode($pictures);
    }
}

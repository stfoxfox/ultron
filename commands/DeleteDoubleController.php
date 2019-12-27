<?php
namespace app\commands;

use app\components\File;
use app\models\TemplateFile;
use app\models\User;
use yii\console\Controller;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;


class DeleteDoubleController extends Controller
{

    public function actionIndex()
    {
        $connection = \Yii::$app->getDb();
        $command = $connection->createCommand("
            SELECT t1.template_id, t1.id
            FROM `template_file` t1
            inner join (
              select t1.id
              from template_file t1
                  inner join template_file t2 on t2.template_id = t1.template_id
                  and t2.created_at < t1.created_at
            ) as t2 on t1.id = t2.id
            group by t1.id
            ");
        $result = $command->queryAll();
        $result = ArrayHelper::getColumn($result, 'id');
        $files = TemplateFile::find()->andWhere([
            'id' => $result
        ])
            ->all();
        foreach ($files as $templateFile)
        {
            $file = File::rootPath($templateFile->file_name, [], '@app/templates') . $templateFile->file_name;
            if(!file_exists($file)){
                TemplateFile::deleteAll(['id'=>$templateFile->id]);
            }
        }

        $command = $connection->createCommand("
            SELECT t1.template_id, t1.id, t2.id as  true_id
            FROM `template_file` t1
            inner join template_file t2 on t2.template_id = t1.template_id
              and t2.created_at > t1.created_at
              order by t1.template_id
            ");
        $result = $command->queryAll();
        $result = ArrayHelper::getColumn($result, 'id');
        $files = TemplateFile::find()->andWhere([
            'id' => $result
        ])
            ->all();
        foreach ($files as $templateFile)
        {
            $templateFile->delete();
        }
    }

}

<?php

namespace app\controllers;

use app\models\Meta;
use yii\web\Controller;
use app\models\CommonModel;
use Yii;

class CommonController extends Controller
{

    /**
     * Sets meta tags and title
     * @param yii\db\ActiveRecord
     * */
    public function setMeta($meta) {
        $metaArray = [
            'title' => $meta->getTitle(),
            'keywords' => $meta->getKeywords(),
            'description' => $meta->getDescription(),
        ];
        $this->view->title = $metaArray['title'];
        $this->view->registerMetaTag(['name' => 'keywords', 'content' => $metaArray['keywords']], 'keywords');
        $this->view->registerMetaTag(['name' => 'description', 'content' => $metaArray['description']], 'description');
    }

    public function beforeAction($action) {
        if ($action->id != 'view') {
            $meta = Meta::getMeta($this->route);
            $this->setMeta($meta);
        }
        return parent::beforeAction($action);
    }
}
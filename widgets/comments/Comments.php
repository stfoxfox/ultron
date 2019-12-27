<?php

namespace app\widgets\comments;

use app\models\Comment;
use app\models\Template;
use yii\data\ActiveDataProvider;

/**
 * Class Comments
 * @package app\widgets\news
 */
class Comments extends \yii\base\Widget
{
    /** @var Template */
    public $template = null;

    /**
     * @return string
     */
    public function run()
    {
        $query = Comment::find()
            ->where([
                'template_id' => $this->template->id,
                'is_published' => true,
            ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
            ],
        ]);

        $comment = new Comment();
        return $this->render('view', [
            'comment' => $comment,
            'template' => $this->template,
            'dataProvider' => $dataProvider,
        ]);
    }
}
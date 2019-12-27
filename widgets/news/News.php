<?php

namespace app\widgets\news;

/**
 * Class News
 * @package app\widgets\news
 */
class News extends \yii\base\Widget
{
    /**
     * @return string
     */
    public function run()
    {
        $models = \app\models\News::find()
            ->orderBy(['id' => SORT_DESC])
            ->limit(4)
            ->all();

        return $this->render('view', compact('models'));
    }
}


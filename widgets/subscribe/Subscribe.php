<?php

namespace app\widgets\subscribe;

use app\models\Banner;

/**
 * Class Subscribe
 * @package app\widgets\news
 */
class Subscribe extends \yii\base\Widget
{
    /**
     * @return string
     */
    public function run()
    {
        $banners = Banner::find()->orderBy(['ordering' => SORT_ASC])->all();
        return $this->render('view', compact('banners'));
    }
}
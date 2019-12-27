<?php

namespace app\widgets\slider;

/**
 * Class TopMenu
 * @package app\widgets\topmenu
 */
class Slider extends \yii\base\Widget
{
    /**
     * @return string
     */
    public function run()
    {
        $models = \app\models\Slider::find()->orderBy(['ordering' => SORT_ASC])->all();
        return $this->render('view', compact('models'));
    }
}
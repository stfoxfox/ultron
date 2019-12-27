<?php

namespace app\widgets\topmenu;

use app\models\Type;

/**
 * Class TopMenu
 * @package app\widgets\topmenu
 */
class TopMenu extends \yii\base\Widget
{
    /**
     * @return string
     */
    public function run()
    {
        $types = Type::find()
            ->orderBy(['ordering' => SORT_ASC])
            ->all();

        return $this->render('view', compact('types'));
    }
}
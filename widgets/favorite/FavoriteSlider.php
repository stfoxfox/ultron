<?php

namespace app\widgets\favorite;

use \yii\base\Widget;

class FavoriteSlider extends Widget{

    /** @array Template */
    public $templates;

    public function run()
    {
        return $this->render('view', ['models' => $this->templates]);
    }
}


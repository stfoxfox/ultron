<?php

namespace app\components;

use yii\helpers\BaseHtml;

class ViewHelper extends BaseHtml
{

    public static function addList($options, $services, $attribute, $suffix = "") {
        ob_start();
        if (!empty($options)) {
            foreach ($options as $option) {
                echo $option->$attribute . $suffix . "<br>";
            }
        }
        if (!empty($services)) {
            foreach ($services as $service) {
                echo $service->$attribute . $suffix . "<br>";
            }
        }
        return ob_get_clean();
    }

}
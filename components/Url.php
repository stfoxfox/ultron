<?php

namespace app\components;

use yii\helpers\ArrayHelper;

/**
 * Class Url
 * @package app\components
 */
class Url extends \yii\helpers\Url
{
    /**
     * @inheritdoc
     */
    public static function current(array $params = [], $scheme = false)
    {
        $currentParams = \Yii::$app->getRequest()->getQueryParams();
        unset($currentParams['author']);
        if (!isset($params[0])) {
            $currentParams[0] = '/' . \Yii::$app->controller->getRoute();
        }

        $route = ArrayHelper::merge($currentParams, $params);
        return static::toRoute($route, $scheme);
    }
}
<?php
namespace app\components;


use yii\web\UrlRule;

class UrlRuleTemplateTypeCategory extends UrlRule
{

    public function createUrl($manager, $route, $params)
    {
        if(!isset($params['category']) || !$params['category'])
            $params['category'] = 'all';
        if(!isset($params['type']) || !$params['type'])
            $params['type'] = 'all';
        if($params['category'] == 'all' && $params['type'] == 'all'){
            unset($params['type']);
            unset($params['category']);
        }
        return parent::createUrl($manager, $route, $params);
    }
}
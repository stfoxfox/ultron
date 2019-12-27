<?php
/**
 * Created by PhpStorm.
 * User: Ziyodulloxon
 * Date: 13.11.2017
 * Time: 12:18
 */

namespace app\components;


use app\models\Template;
use yii\base\BaseObject;
use yii\web\UrlRuleInterface;

class TemplateUrlRule extends BaseObject implements UrlRuleInterface
{
    public function createUrl($manager, $route, $params) {
        if ($route == 'template/view' && $template = Template::findOne($params['id'])) {
            return $template->alias . '.html';
        }
        return false;
    }

    public function parseRequest($manager, $request) {
        $pathInfo = $request->getPathInfo();
        $pattern = "/^([\w-]+).html/";
        if (preg_match($pattern, $pathInfo, $matches)) {
            if ($template = Template::findOne(['alias' => $matches[1]])) {
                if ($template->alias == $matches[1]) {
                    return [
                        '/template/view',
                        [
                            'id' => $template->id,
                        ]
                    ];
                }
                return false;
            }
            return false;
        }
        return false;
    }
}
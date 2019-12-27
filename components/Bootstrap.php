<?php

namespace app\components;

use yii\base\BootstrapInterface;

/**
 * Users module bootstrap class.
 */
class Bootstrap implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
	foreach($app->urlManager->rules as $k=>$rule){
	    if(isset($rule->route) && $rule->route == 'users/user/<_a>')
		unset($app->urlManager->rules[$k]);
	    if(isset($rule->route) && $rule->route == 'users/guest/<_a>')
		unset($app->urlManager->rules[$k]);
	}
    }
}

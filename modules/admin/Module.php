<?php

namespace app\modules\admin;

use yii\helpers\Url;

/**
 * admin module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\admin\controllers';

    /**
     * @inheritdoc
     */
    public $layout = 'main';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        \Yii::$app->setHomeUrl('/admin');
        \Yii::$app->homeUrl = Url::to('/admin');
        \Yii::$app->user->loginUrl = Url::to(['/admin/default/login']);

        // custom initialization code goes here
    }
}

<?php

namespace app\controllers\user;

use yii\filters\AccessControl;

/**
 * Class ProfileController
 * @package app\controllers\user
 */
class ProfileController extends UserCommonController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionView()
    {
        return $this->render('view');
    }
}

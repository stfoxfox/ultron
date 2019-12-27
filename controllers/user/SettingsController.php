<?php

namespace app\controllers\user;

use app\components\File;
use app\models\UserChanging;
use Yii;
use app\models\User;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;

/**
 * Class SettingsController
 * @package app\controllers\user
 */
class SettingsController extends UserCommonController
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
                        'actions' => ['index', 'avatar', 'get-settings-code', 'test'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @return array|string|Response
     */
    public function actionIndex()
    {
        $model = User::findOne(\Yii::$app->user->id);
        $model->scenario = User::SCENARIO_SETTINGS_USER;

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());

            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('confirm.success', 'Изменения в профиле успешно сохранены.');
                if ($model->isPasswordChanged) {
                    Yii::$app->session->setFlash('changed-password', 'Ваш пароль был успешно изменен.');
                }

                return $this->refresh();
            }
        }

        return $this->render('index', compact('model'));
    }

    /**
     * @return array
     */
    public function actionGetSettingsCode()
    {
        $user = User::findOne(Yii::$app->user->id);
        $user->setSettingsCode();

        if ($user->role === User::ROLE_WEBMASTER) {
            $this->sendSMSCode($user);
        } else {
            $this->sendEmailCode($user);
        }
        Yii::$app->response->format = Response::FORMAT_JSON;

        return [
            'status' => true,
        ];
    }

    /**
     * @param User $user
     * @return mixed
     */
    private function sendSMSCode(User $user)
    {
        return Yii::$app->sms->send([$user->phone], 'Проверочный код для ввода на сайте: ' .
            Yii::$app->session->get('settingsCode'));
    }

    /**
     * @param User $user
     * @return mixed
     */
    private function sendEmailCode(User $user)
    {
        return Yii::$app->mailer->userConfirmSettings($user);
    }

//    /**
//     * @param null $code
//     * @return array|string|Response
//     * @throws NotFoundHttpException
//     */
//    public function actionConfirm($code = null)
//    {
//        /** @var UserChanging $model */
//        $model = UserChanging::findLast(Yii::$app->user->id);
//        if (!$model) {
//            throw new NotFoundHttpException();
//        }
//
//        if ($code) {
//            if ($code === $model->confirmation_code) {
//                if ($model->applyChanges()) {
//                    Yii::$app->session->setFlash('confirm.success', true);
//                    return $this->redirect(['index']);
//                }
//            }
//        } else if (Yii::$app->request->isPost) {
//            $model->load(Yii::$app->request->post());
//
//            if (Yii::$app->request->isAjax) {
//                Yii::$app->response->format = Response::FORMAT_JSON;
//                return ActiveForm::validate($model);
//            }
//
//            if ($model->applyChanges()) {
//                Yii::$app->session->setFlash('confirm.success', true);
//                return $this->redirect(['index']);
//            }
//        }
//
//        return $this->render('confirm', compact('model'));
//    }

    /**
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionAvatar()
    {
        $model = User::findOne(Yii::$app->user->id);
        if (!$model) {
            throw new NotFoundHttpException();
        }

        $model->picture = File::save($model, 'picture');
        $status = $model->save(false, ['picture']);

        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'url' => File::src($model, 'picture', [100, 100]),
            'errors' => $model->getErrors(),
            'status' => $status,
        ];
    }
}

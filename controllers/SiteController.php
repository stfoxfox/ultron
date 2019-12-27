<?php

namespace app\controllers;

use app\components\File;
use app\components\Translit;
use app\components\Url;
use app\models\Banner;
use app\models\ForgotForm;
use app\models\Invoice;
use app\models\SellerRequest;
use app\models\Subscribe;
use app\models\Template;
use app\models\TemplateFile;
use app\models\TemplatePicture;
use app\models\User;
use Yii;
use yii\base\DynamicModel;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\web\Controller;
use app\models\LoginForm;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

class SiteController extends CommonController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @param null $secret
     * @return array|string|Response
     */
    public function actionForgot($secret = null)
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        if ($secret) {
            $user = ForgotForm::findUserByKey($secret);
            if ($user) {
                ForgotForm::createNewPassword($user);
                Yii::$app->session->setFlash('forgot.success', 'На вашу почту были отправлены новые данные для входа.');
            } else {
                Yii::$app->session->setFlash('forgot.error', 'Вы ввели не действительный или истекший код.');
            }
        } else {
            $model = new ForgotForm();
            $model->load(Yii::$app->request->post());

            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }

            if (Yii::$app->request->isPost) {
                if ($model->validate()) {
                    $model->sendEmail();
                    Yii::$app->session->setFlash('forgot.send', 'На вашу почту было отправлено ' .
                        'сообщение с дальнейшими инструкциями.');
                }
            }
        }

        return $this->render('forgot', compact('model'));
    }

    /**
     * Login action.
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());

            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            if ($model->login()) {
                return $this->redirect(['/user/settings']);
            }
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionRegister()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new User();
        $model->scenario = User::SCENARIO_REGISTER_USER;

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());

            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('register-success', 'Регистрация выполнена успешно! <br/> ' .
                    'На Вашу почту было отправлено письмо для подтверждения. <br/> ' .
                    'Для входа на сайте Вам необходимо следовать инструкциям указанным в этом письме.');
            }
        }

        return $this->render('register', [
            'model' => $model,
        ]);
    }

    /**
     * @param $code
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionConfirm($code)
    {
        if (empty($code)) {
            throw new NotFoundHttpException();
        }

        /** @var User $model */
        $model = User::find()->where([
            'email_confirmation' => $code,
        ])->one();

        if (!$model) {
            return $this->render('inactual_token');
//            throw new NotFoundHttpException("Учетная запись уже активирована.", 0);
        }

        $model->confirmEmail();

        return $this->render('confirm', compact('model'));
    }

    /**
     * Logout action.
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    /**
     * @return string
     */
    public function actionSeller()
    {
        $model = new SellerRequest();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->sendEmail();
            Yii::$app->session->setFlash('seller', 'Спасибо, Ваша заявка успешно принята! Мы свяжемся с Вами в ближайшее время.');
            return $this->refresh();
        }
        return $this->render('seller', compact('model'));
    }

    /**
     * @return string
     */
    public function actionSellerReg()
    {
        $model = new User();
        $model->scenario = User::SCENARIO_REGISTER_WEBMASTER;
        $model->load(Yii::$app->request->post());
        $model->role = User::ROLE_WEBMASTER;

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if (Yii::$app->request->isPost && $model->save()) {
            Yii::$app->session->setFlash('seller-reg', 'Веб-мастер успешно создан. <br/> Данные для входа отправлены на указанную почту.');
            return $this->refresh();
        }
        return $this->render('seller-reg', compact('model'));
    }

    /**
     * @return array
     */
    public function actionSubscribe()
    {
        $email = Yii::$app->request->post('email');
        if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'message' => 'Вы ввели не верный email.',
            ];
        }

        $exists = Subscribe::find()->where(['email' => $email])->exists();
        if ($exists) {
            $message = 'Такой email уже есть в базе.';
        } else {
            (new Subscribe([
                'email' => $email,
            ]))->save(false);
            $message = 'Спасибо, подписка выполнена успешно.';
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'message' => $message,
        ];
    }

//    public function actionTest() {
//        phpinfo();
//        $invoice = Invoice::findOne(157);
//        $template = Template::findOne(56);
//        return $this->renderAjax('test', [
//            'invoice' => $invoice,
//            'template' => $template
//        ]);
//        $template = Template::findOne(56);
//        $invoice = Invoice::findOne(233);
//        Yii::$app->mailer->productSoldWebmaster($template, $invoice);
//    }

//    public function actionUpdateAliases() {
//        foreach (Template::find()->each(100) as $template) {
//            /** @var $template Template */
//            if (!$template->alias) {
//                $template->alias = Translit::str2url(trim($template->title)) . '-' . $template->id;
//                if (!$template->save(false)) {
//                    var_dump($template->errors);die;
//                }
//            }
//        }
//    }
}

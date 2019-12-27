<?php

namespace app\components;

use app\models\Comment;
use app\models\Invoice;
use app\models\Review;
use app\models\SellerRequest;
use app\models\Template;
use Yii;
use yii\base\ErrorException;

/**
 * Class Mailer
 * @package app\components
 */
class Mailer extends \yii\swiftmailer\Mailer
{
    /**
     * После регистрации нового пользователя отправляем проверочную ссылку.
     * @param \app\models\User $user
     * @param $code
     * @return bool
     */
    public function userRegisterConfirmation(\app\models\User $user, $code)
    {
        $from = [Yii::$app->params['noreplyEmail'] => Yii::$app->name];
        $subject = 'Регистрация на сайте ultron.pro';
        $url = Yii::$app->urlManager->createAbsoluteUrl(['site/confirm', 'code' => $code]);

        return Yii::$app->mailer->compose('@app/mail/user/register-confirmation', compact('user', 'url'))
            ->setTo($user->email)
            ->setFrom($from)
            ->setSubject($subject)
            ->send();
    }

    /**
     * После подтверждения ссылки на регистрацию.
     * @param \app\models\User $user
     * @return bool
     */
    public function userRegisterSuccess(\app\models\User $user)
    {
        $from = [Yii::$app->params['noreplyEmail'] => Yii::$app->name];
        $subject = 'Регистрация на сайте ultron.pro';

        return Yii::$app->mailer->compose('@app/mail/user/register-success', compact('user'))
            ->setTo($user->email)
            ->setFrom($from)
            ->setSubject($subject)
            ->send();
    }

    /**
     * @param \app\models\User $user
     * @return bool
     */
    public function userConfirmSettings(\app\models\User $user)
    {
        $from = [Yii::$app->params['noreplyEmail'] => Yii::$app->name];
        $subject = 'Подтверждение изменения профиля на сайте ultron.pro';

        return Yii::$app->mailer->compose('@app/mail/user/confirm-settings', compact('user'))
            ->setTo($user->email)
            ->setFrom($from)
            ->setSubject($subject)
            ->send();
    }

    /**
     * @param \app\models\User $user
     * @return bool
     */
    public function userChangedStatus(\app\models\User $user)
    {
        $from = [Yii::$app->params['noreplyEmail'] => Yii::$app->name];
        $subject = 'Изменение статуса профиля на сайте ultron.pro';

        return Yii::$app->mailer->compose('@app/mail/user/changed-status', compact('user'))
            ->setTo($user->email)
            ->setFrom($from)
            ->setSubject($subject)
            ->send();
    }

    /**
     * @param \app\models\User $user
     * @return bool
     */
    public function invoicePaid(\app\models\User $user)
    {
        $from = [Yii::$app->params['noreplyEmail'] => Yii::$app->name];
        $subject = 'Покупка шаблона на сайте ultron.pro';

        return Yii::$app->mailer->compose('@app/mail/invoice/paid', compact('user'))
            ->setTo($user->email)
            ->setFrom($from)
            ->setSubject($subject)
            ->send();
    }

    /**
     * @param Invoice $invoice
     * @return bool
     */
    public function productSoldAdmin(Invoice $invoice)
    {
        try {
            $from = [Yii::$app->params['noreplyEmail'] => Yii::$app->name];
            $subject = 'Ultron.pro - новый заказ #' . $invoice->id;

            return Yii::$app->mailer->compose('@app/mail/invoice/productSoldAdmin', compact('invoice'))
                ->setTo(Yii::$app->params['adminEmail'])
                ->setFrom($from)
                ->setSubject($subject)
                ->send();
        } catch (\ErrorException $e) {
            return $e->getTraceAsString();
        }
    }

    /**
     * @param Template $template
     * @param Invoice $invoice
     * @return bool
     */
    public function productSoldWebmaster(Template $template, Invoice $invoice)
    {
        try {
            $from = [Yii::$app->params['noreplyEmail'] => Yii::$app->name];
            $subject = 'Ultron.pro - покупка шаблона';

            return Yii::$app->mailer->compose('@app/mail/invoice/productSoldWebmaster', compact('template', 'invoice'))
                ->setTo($template->user->email)
                ->setFrom($from)
                ->setSubject($subject)
                ->send();
        } catch (\ErrorException $e) {
            return $e->getTraceAsString();
        }
    }

    /**
     * @param \app\models\User $user
     * @return bool
     */
    public function userForgot(\app\models\User $user)
    {
        $from = [Yii::$app->params['noreplyEmail'] => Yii::$app->name];
        $subject = 'Восстановление пароля на сайте ultron.pro';

        return Yii::$app->mailer->compose('@app/mail/user/forgot', compact('user'))
            ->setTo($user->email)
            ->setFrom($from)
            ->setSubject($subject)
            ->send();
    }

    /**
     * @param \app\models\User $user
     * @return bool
     */
    public function userForgotNewPassword(\app\models\User $user)
    {
        $from = [Yii::$app->params['noreplyEmail'] => Yii::$app->name];
        $subject = 'Данные для входа на сайте ultron.pro';

        $url = null !== $user->email_confirmation ? Yii::$app->urlManager->createAbsoluteUrl(['site/confirm', 'code' => $user->email_confirmation]) : null;

        return Yii::$app->mailer->compose('@app/mail/user/forgot-new-password', compact('user', 'url'))
            ->setTo($user->email)
            ->setFrom($from)
            ->setSubject($subject)
            ->send();
    }

    /**
     * @param SellerRequest $request
     * @return bool
     */
    public function sellerRequest(SellerRequest $request)
    {
        $subject = "Новый запрос на добавление вебмастера";
        Yii::$app->mailer->compose('@app/mail/user/seller-request', ['user' => $request])
            ->setTo(Yii::$app->params['sellerRequestEmail'])
            ->setFrom(Yii::$app->params['noreplyEmail'])
            ->setSubject($subject)
            ->send();
    }

    /**
     * @param Template $template
     * @param $users
     * @param $link
     * @return bool
     */
    public function receivedMessage(Template $template, $users, $link)
    {
        $to = [];
        foreach ($users as $user){
            $to[] = $user->email;
        }
        $subject = "Новый комментарий";
        Yii::$app->mailer->compose('@app/mail/user/received-message', [
            'template' => $template,
            'link' => $link
        ])
            ->setTo($to)
            ->setFrom(Yii::$app->params['noreplyEmail'])
            ->setSubject($subject)
            ->send();
    }

    /**
     * @param string $appeal
     * @param Review $review
     * @param string $link
     * @return bool
     */
    public function sendAppeal($appeal, Review $review, $link)
    {
        $subject = "Жалоба к комментарию";
        Yii::$app->mailer->compose('@app/mail/user/appeal', [
            'appeal' => $appeal,
            'review' => $review,
            'author' => Yii::$app->getUser()->getIdentity(),
            'link' => $link
        ])
            ->setTo(Yii::$app->params['appealEmail'])
            ->setFrom(Yii::$app->params['noreplyEmail'])
            ->setSubject($subject)
            ->send();
    }
}
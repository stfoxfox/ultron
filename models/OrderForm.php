<?php

namespace app\models;

use yii\base\Model;
use yii\db\Expression;
use yz\shoppingcart\CartPositionInterface;
use yz\shoppingcart\ShoppingCart;

/**
 * Class OrderForm
 * @package app\models
 */
class OrderForm extends Model
{
//    const PAYMENT_TYPE_YANDEX = 'yandex';
    const PAYMENT_TYPE_WEBMONEY = 'WebMoney';
    const PAYMENT_TYPE_BANK_CARD = 'BankCard';
    const PAYMENT_TYPE_SBERBANK_ONLINE = 'SberbankOnline';
    const PAYMENT_TYPE_VTB24 = 'VTB24';
    const PAYMENT_TYPE_RSB = 'RSB';
    const PAYMENT_TYPE_PSB = 'PSB';

    public $email;
    public $paymentType;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => function ($value) {
                return trim($value);
            }],
            ['paymentType', 'required'],
            ['paymentType', 'in', 'range' => [
                self::PAYMENT_TYPE_WEBMONEY,
                self::PAYMENT_TYPE_BANK_CARD,
                self::PAYMENT_TYPE_SBERBANK_ONLINE,
                self::PAYMENT_TYPE_VTB24,
                self::PAYMENT_TYPE_RSB,
                self::PAYMENT_TYPE_PSB
            ]],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => User::className(), 'targetAttribute' => 'email', 'message' => 'Эта почта уже используется другим пользователем'],
            ['email', 'required', 'when' => function () {
                return \Yii::$app->user->isGuest;
            }],
        ];
    }

    /**
     * @return Invoice|bool
     */
    public function execute()
    {
        if (!$this->validate()) {
            return false;
        }

        if (\Yii::$app->user->isGuest) {
            $user = $this->createUser();
            $user->login();
        } else {
            $user = User::find()
                ->where(['id' => \Yii::$app->user->id])
                ->one();
        }

        return $this->createInvoice($user);
    }

    /**
     * @return User
     */
    private function createUser()
    {
        $password = User::generatePassword();
        $user = new User([
            'username' => User::uniqueUsername($this->email),
            'email' => $this->email,
            'password1' => $password,
        ]);
        $user->save(false);
        return $user;
    }

    /**
     * @param User $user
     * @return Invoice|bool
     */
    private function createInvoice(User $user)
    {
        $invoice = new Invoice([
            'user_id' => $user->id,
        ]);

        if (!$invoice->save(false)) {
            return false;
        }
        $invoice->refresh();

        if (!$this->createInvoiceTemplates($invoice)) {
            return false;
        }

        $this->calculateInvoiceSum($invoice);

        // todo: удалить после настройки оплаты
//        $invoice->sell();

        return $invoice;
    }

    /**
     * @param Invoice $invoice
     * @return bool
     */
    private function createInvoiceTemplates(Invoice $invoice)
    {
        /** @var ShoppingCart $cart */
        $cart = \Yii::$app->cart;
        foreach ($cart->positions as $position) {
            $invoiceTemplate = new InvoiceTemplate([
                'invoice_id' => $invoice->id,
                'template_id' => $position->id,
                'price' => $position->getTemplate()->getActualPrice(),
            ]);
            if (!$invoiceTemplate->save(false)) {
                return false;
            }
            if (!$this->createInvoiceTemplateServices($invoiceTemplate, $position)) {
                return false;
            }
            if (!$this->createInvoiceTemplateOptions($invoiceTemplate, $position)) {
                return false;
            }
        }

        $cart->removeAll();
        return true;
    }

    /**
     * @param InvoiceTemplate $invoiceTemplate
     * @param CartPositionInterface $position
     * @return bool
     */
    private function createInvoiceTemplateOptions(InvoiceTemplate $invoiceTemplate, CartPositionInterface $position)
    {
        /** @var Option $option */
        foreach ($position->getOptions() as $option) {
            $templateOption = new InvoiceTemplateOption([
                'invoice_template_id' => $invoiceTemplate->id,
                'option_id' => $option->id,
                'price' => $option->price,
            ]);
            if (!$templateOption->save(false)) {
                return false;
            }
        }
        return true;
    }

    /**
     * @param InvoiceTemplate $invoiceTemplate
     * @param CartPositionInterface $position
     * @return bool
     */
    private function createInvoiceTemplateServices(InvoiceTemplate $invoiceTemplate, CartPositionInterface $position)
    {
        /** @var Service $service */
        foreach ($position->getServices() as $service) {
            $templateService = new InvoiceTemplateService([
                'invoice_template_id' => $invoiceTemplate->id,
                'service_id' => $service->id,
                'price' => $service->price,
            ]);
            if (!$templateService->save(false)) {
                return false;
            }
        }
        return true;
    }

    /**
     * @param Invoice $invoice
     */
    private function calculateInvoiceSum(Invoice $invoice)
    {
        $sum = 0;
        foreach ($invoice->invoiceTemplates as $template) {
            $sum += $template->price;
            foreach ($template->invoiceOptions as $option) {
                $sum += $option->price;
            }
            foreach ($template->invoiceServices as $option) {
                $sum += $option->price;
            }
        }

        $invoice->sum = $sum;
        $invoice->save(false, ['sum']);
    }

}
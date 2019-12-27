<?php
/**
 * Created by PhpStorm.
 * User: Ziyodulloxon
 * Date: 06.11.2017
 * Time: 11:07
 */

namespace app\controllers;

use app\models\Snippet;
use app\models\Test;
use Yii;
use app\models\Invoice;
use app\models\Paymaster;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\User;

class PaymentController extends CommonController
{

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['invoice-confirmation', 'invoice-notification'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['invoice-confirmation', 'invoice-notification'],
                        'ips' => ['91.200.28.*', '91.227.52.*']
                    ]
                ]
            ]
        ];
    }

    public function actionSend($id, $type) {
        $invoice = Invoice::findOne($id);
        $user = $invoice->user;
        $invoiceTemplates = $invoice->invoiceTemplates;

        $options = [];
        $services = [];

        foreach ($invoiceTemplates as $key => $template) {
            if ($template->invoiceOptions) {
                $options[$template->template->title] = $template->invoiceOptions;
            }
            if ($template->invoiceServices) {
                $services[$template->template->title] = $template->invoiceServices;
            }
        }

        return $this->renderAjax('send', [
            'invoice' => $invoice,
            'user' => $user,
            'invoiceTemplates' => $invoiceTemplates,
            'options' => $options,
            'services' => $services,
            'type' => $type,
            'descr' => $invoice->descrList
        ]);
    }

    public function actionInvoiceConfirmation() {
        if (Yii::$app->request->isPost) {
            $id = Yii::$app->request->post('LMI_PAYMENT_NO');
            $post = Yii::$app->request->post();
            $invoice = Invoice::findOne($id);
            $match = true;
            $check = [
                'LMI_PREREQUEST' => '1',
                'LMI_MERCHANT_ID' => Yii::$app->params['payMaster']['merchantId'],
                'LMI_PAYMENT_NO' => $invoice->id,
                'LMI_PAYMENT_AMOUNT' => $invoice->sum,
                'LMI_CURRENCY' => 'RUB',
                'LMI_PAID_AMOUNT' => $invoice->sum,
                'LMI_PAID_CURRENCY' => 'RUB',
            ];
            foreach ($check as $key => $value) {
                if ($value != $post[$key]) {
                    $match = false;
                }
            }

            header('Content-Type: text/plain; charset=UTF-8');

            if ($match && $invoice->status == Invoice::STATUS_PENDING) {
                echo 'YES';
            } else {
                echo "NOT";
            }
        }
    }

    public function actionInvoiceNotification() {
        if (Yii::$app->request->isPost) {
            $paymaster = new Paymaster();
            $paymaster->attributes = Yii::$app->request->post();
            $invoice = Invoice::findOne($paymaster->LMI_PAYMENT_NO);
            if ($paymaster->validate()) {

                $test = new Test();
                $test->title = "invoice test";
                $test->time = time();
                ob_start();print_r($paymaster);
                $test->value = ob_get_clean();
                $test->save(false);

                $paymaster->save();
                $invoice->sell();
                echo 'OK';
            } else {
                echo "Не проканало!";
            }
        }
    }

    /**
     * Shows success page after successful payment
     * @return string
     * @throws BadRequestHttpException if request params don't match
     * */
    public function actionSuccess() {
        $get = Yii::$app->request->get();
        $status = Invoice::compareSuccess($get);
        $invoice = $status[0];
        if ($invoice instanceof Invoice) {
            if ($invoice->status == Invoice::STATUS_PAID && $status[1]) {
                $header = Snippet::findByKey(Paymaster::PAYMENT_SUCCESS_PAGE)->description;
                $message = Snippet::findByKey(Paymaster::PAYMENT_SUCCESS_PAGE)->value;
            } else {
                $header = Snippet::findByKey(Paymaster::PAYMENT_SUCCESS_PENDING_PAGE)->description;
                $message = Snippet::findByKey(Paymaster::PAYMENT_SUCCESS_PENDING_PAGE)->value;
            }
            return $this->render('success', [
                'header' => $header,
                'message' => $message
            ]);
        } else {
//            var_dump($invoice);
            throw new BadRequestHttpException("Данные платежа не совпадают");
        }
    }

    public function actionFailure() {
        $snippet = Snippet::findByKey('payment-failure-page');
        return $this->render('failure', [
            'snippet' => $snippet
        ]);
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if ($action->id == 'invoice-confirmation' or $action->id == 'invoice-notification') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

}
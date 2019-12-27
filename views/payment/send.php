<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

/**
 * @var $invoice app\models\Invoice
 * @var $user app\models\User
 * @var $invoiceTemplates array
 * @var $options array
 * @var $services array
 * @var $this yii\web\View
 * @var $type string
 * @var $descr string
 * */

$i = 0;

?>

Пожалуйста, подождите...

<?php ActiveForm::begin([
    'action' => 'https://paymaster.ru/Payment/Init',
    'options' => [
        'class' => 'payment-form',
    ]
])?>

    <?= Html::input('hidden', 'LMI_MERCHANT_ID', Yii::$app->params['payMaster']['merchantId'])?>
    <?= Html::input('hidden', 'LMI_PAYMENT_AMOUNT', $invoice->sum)?>
    <?= Html::input('hidden', 'LMI_CURRENCY', 'RUB')?>
    <?= Html::input('hidden', 'LMI_PAYMENT_NO', $invoice->id)?>
    <?= Html::input('hidden', 'LMI_PAYMENT_DESC', $descr)?>
<!--    --><?//= Html::input('hidden', 'LMI_SIM_MODE', '0')?>
    <?= Html::input('hidden', 'LMI_PAYER_EMAIL', $user->email)?>
    <?= Html::input('hidden', 'LMI_PAYMENT_METHOD', $type)?>

    <? foreach ($invoiceTemplates as $key => $template): ?>
        <?= Html::input('hidden', "LMI_SHOPPINGCART.ITEMS[$i].NAME", concat($template->template->title))?>
        <?= Html::input('hidden', "LMI_SHOPPINGCART.ITEMS[$i].QTY", 1)?>
        <?= Html::input('hidden', "LMI_SHOPPINGCART.ITEMS[$i].PRICE", $template->template->getActualPrice());?>
        <?= Html::input('hidden', "LMI_SHOPPINGCART.ITEMS[$i].TAX", 'vat0');?>
        <? $i++ ?>
    <? endforeach ?>

    <? foreach ($options as $key => $option): ?>
        <? foreach ($option as $o): ?>
            <?= Html::input('hidden', "LMI_SHOPPINGCART.ITEMS[$i].NAME", concat($o->option->title) . ' для ' . $key)?>
            <?= Html::input('hidden', "LMI_SHOPPINGCART.ITEMS[$i].QTY", 1)?>
            <?= Html::input('hidden', "LMI_SHOPPINGCART.ITEMS[$i].PRICE", $o->option->price)?>
            <?= Html::input('hidden', "LMI_SHOPPINGCART.ITEMS[$i].TAX", 'vat0')?>
            <? $i++ ?>
        <? endforeach ?>
    <? endforeach ?>

    <? foreach ($services as $key => $service): ?>
        <? foreach ($service as $s): ?>
            <?= Html::input('hidden', "LMI_SHOPPINGCART.ITEMS[$i].NAME", concat($s->service->title) . ' для ' . $key)?>
            <?= Html::input('hidden', "LMI_SHOPPINGCART.ITEMS[$i].QTY", 1)?>
            <?= Html::input('hidden', "LMI_SHOPPINGCART.ITEMS[$i].PRICE", $s->service->price);?>
            <?= Html::input('hidden', "LMI_SHOPPINGCART.ITEMS[$i].TAX", 'vat0');?>
            <? $i++ ?>
        <? endforeach ?>
    <? endforeach ?>

<?php ActiveForm::end() ?>

<?php
$script = "$(document).ready(function () {
    $('.payment-form').submit();
});";
$this->registerJs($script, \yii\web\View::POS_END);


<?php

use app\widgets\topmenu\TopMenu;
use app\widgets\profileblock\ProfileBlock;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use app\models\OrderForm;
use yii\helpers\Html;

/** @var $cart \yz\shoppingcart\ShoppingCart */
/** @var $this \yii\web\View */

?>

<?php if (Yii::$app->user->isGuest): ?>
<!--    <div class="push30"></div>-->
    <ul class="breadcrumb">
        <li><a href="<?= Url::home() ?>">Главная</a></li>
        <i class="material-icons">navigate_next</i>
        <li class="active">Корзина</li>
    </ul>
<?php endif; ?>

<div class="title-h2">Корзина</div>

<div class="main-cart-wrapper">
    <?php \yii\widgets\Pjax::begin(['id' => 'main-cart-items-pjax']) ?>

    <?php if ($cart->count > 0): ?>
        <div class="main-cart-body">
            <?php foreach ($cart->getPositions() as $position): ?>
                <?= $this->render('_index-item-view', compact('position')) ?>
            <?php endforeach; ?>
        </div>

        <div class="main-cart-total">
            <div class="row">
                <div class="col-sm-6">
                    Итого к оплате:
                </div>
                <div class="col-sm-6 text-right-sm">
                    <span class="total-summ"><?= $cart->getCost() ?> р.</span>
                </div>
            </div>
        </div>
    <?php else: ?>
        у вас в корзине ничего нет.
    <?php endif; ?>

    <?php \yii\widgets\Pjax::end() ?>

    <div id="main-cart-payment-form"
         style="display: <?= $cart->count == 0 ? 'none' : 'block' ?>;">

        <?php $form = ActiveForm::begin([
            'enableClientValidation' => false,
            'enableAjaxValidation' => true,
        ]) ?>

        <div class="push20"></div>
        <div class="main-cart-payments">
            <div class="title-h4">
                Выберите способ оплаты
            </div>
            <div class="push10"></div>

            <div class="custom-pay-radio">
                <input type="radio" name="OrderForm[paymentType]"
                       value="<?= OrderForm::PAYMENT_TYPE_BANK_CARD ?>" id="payment1"
                       checked="checked">

                <label for="payment1">
                    <i class="material-icons unchecked">radio_button_unchecked</i>
                    <i class="material-icons checked">radio_button_checked</i>
                    <img src="<?= Url::base() ?>/images/visa-payments.jpg">
                </label>
            </div>

            <div class="custom-pay-radio">
                <input type="radio" name="OrderForm[paymentType]"
                       value="<?= OrderForm::PAYMENT_TYPE_WEBMONEY ?>" id="payment2">

                <label for="payment2">
                    <i class="material-icons unchecked">radio_button_unchecked</i>
                    <i class="material-icons checked">radio_button_checked</i>
                    <img src="<?= Url::base() ?>/images/webmoney-payments.png">
                </label>
            </div>

            <div class="custom-pay-radio">
                <input type="radio" name="OrderForm[paymentType]"
                       value="<?= OrderForm::PAYMENT_TYPE_PSB ?>" id="payment3">

                <label for="payment3">
                    <i class="material-icons unchecked">radio_button_unchecked</i>
                    <i class="material-icons checked">radio_button_checked</i>
                    <img src="<?= Url::base() ?>/images/psb-payments.png">
                </label>
            </div>

            <div class="custom-pay-radio">
                <input type="radio" name="OrderForm[paymentType]"
                       value="<?= OrderForm::PAYMENT_TYPE_RSB ?>" id="payment4">

                <label for="payment4">
                    <i class="material-icons unchecked">radio_button_unchecked</i>
                    <i class="material-icons checked">radio_button_checked</i>
                    <img src="<?= Url::base() ?>/images/rsb-payments.png">
                </label>
            </div>

            <div class="custom-pay-radio">
                <input type="radio" name="OrderForm[paymentType]"
                       value="<?= OrderForm::PAYMENT_TYPE_SBERBANK_ONLINE ?>" id="payment5">

                <label for="payment5">
                    <i class="material-icons unchecked">radio_button_unchecked</i>
                    <i class="material-icons checked">radio_button_checked</i>
                    <img src="<?= Url::base() ?>/images/sberbank-online-payments.png">
                </label>
            </div>

            <div class="custom-pay-radio">
                <input type="radio" name="OrderForm[paymentType]"
                       value="<?= OrderForm::PAYMENT_TYPE_VTB24 ?>" id="payment6">

                <label for="payment6">
                    <i class="material-icons unchecked">radio_button_unchecked</i>
                    <i class="material-icons checked">radio_button_checked</i>
                    <img src="<?= Url::base() ?>/images/vtb24-payments.jpg">
                </label>
            </div>

        </div>

        <?php if (Yii::$app->user->isGuest): ?>
            <div class="push20"></div>
            <div class="main-cart-payments">
                <div class="title-h4">Введите email <span class="required-text">*</span>:</div>
                <div class="push10"></div>

                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'email')->textInput([
                            'placeholder' => 'Введите вашу электронную почту',
                        ])->label(false) ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        
        <div class="simple-agreement black">
            <input type="checkbox" required="required" id="payagree" />
            <label for="payagree">С <a href="https://ultron.pro/page/agreement" target="_blank">пользовательским соглашением</a> ознакомлен и согласен.</label>
        </div>
        <br/>

        <?= Html::submitButton('Оплатить', ['class' => 'btn big']) ?>

        <?php ActiveForm::end() ?>

    </div>

</div>
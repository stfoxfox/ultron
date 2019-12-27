<?php

use app\widgets\profileblock\ProfileBlock;
use app\widgets\topmenu\TopMenu;
use yii\widgets\ActiveForm;
use app\models\Payout;
use app\models\User;
use yii\helpers\Url;

/** @var $this \yii\web\View */
/** @var $model \app\models\User */

?>

<div class="title-h2">Настройки</div>
<div class="settings">

    <?php if (Yii::$app->session->hasFlash('confirm.success')): ?>
        <div class="alert alert-success push20">
            <?= Yii::$app->session->getFlash('confirm.success') ?>
        </div>
        <div class="push30"></div>
    <?php endif ?>

    <?php if (Yii::$app->session->hasFlash('changed-password')): ?>
        <div class="alert alert-success push20">
            <?= Yii::$app->session->getFlash('changed-password') ?>
        </div>
        <div class="push30"></div>
    <?php endif ?>

    <?php $form = ActiveForm::begin([
        'id' => 'profile-settings-form',
        'options' => ['class' => 'rf'],
        'enableClientValidation' => false,
        'validateOnBlur' => false,
        'validateOnChange' => false,
        'enableAjaxValidation' => true,
    ]) ?>

    <?= $form->field($model, 'email')->textInput([
        'class' => 'form-control required',
    ]) ?>

    <?= $form->field($model, 'first_name')->textInput([
        'class' => 'form-control required',
    ]) ?>

    <?= $form->field($model, 'last_name')->textInput([
        'class' => 'form-control required',
    ]) ?>

    <?= $form->field($model, 'phone', [
        'template' => "{label}\n<i class=\"material-icons help-icon\" data-hasqtip=\"3\"
           aria-describedby=\"qtip-3\">help</i>
        <div class=\"hide\">
            Вводите номер телефона в международном формате, например для России это
            +7xxxxxxxxxx,
            для Украины +38xxxxxxxxxx и т.д.
        </div>\n{input}",
    ])->textInput(['class' => 'form-control'])->label('Номер мобильного телефона') ?>
    <div class="push15"></div>

    <div class="change-pass-block">
        <div class="title">
            <span class="upper f12 dashed" id="change-password-link">
                Изменить пароль
            </span>
        </div>

        <div class="hide-block">
            <div class="push15"></div>

            <?= $form->field($model, 'currentPassword')->passwordInput([
                'class' => 'form-control required',
            ]) ?>
            <?= $form->field($model, 'password1')->passwordInput([
                'class' => 'form-control required',
            ]) ?>
            <?= $form->field($model, 'password2')->passwordInput([
                'class' => 'form-control required',
            ]) ?>
        </div>
    </div>

    <div class="push25"></div>

    <?php if (Yii::$app->user->getIsWebmaster()): ?>
        <div class="lk-payments-settings-block">
            <div class="element">
                <div class="row min">
                    <div class="col-sm-4 col-xs-8">
                        <span class="f13">Партнерский процент</span>
                        <div class="push10 visible-xs"></div>
                    </div>
                    <div class="col-sm-8 col-xs-4">
                        <b><?= $model->incomePercent() ?>%</b>
                    </div>
                </div>
            </div>
            <div class="element">
                <div class="row min">
                    <div class="col-sm-4">
                        <span class="f13">Платежная система</span>
                        <div class="push10 visible-xs"></div>
                    </div>
                    <div class="col-sm-8">
                        <div class="row min">
                            <div class="col-sm-6">
                                <div class="select-block">
                                    <?= $form->field($model, 'default_payment_system')->dropDownList(Payout::getPaymentTypes(), [
                                        'id' => 'payments_select',
                                        'class' => 'select-styler',
                                    ])->label(false) ?>
                                </div>
                                <div class="push10 visible-xs"></div>
                            </div>
                            <div class="col-sm-6">
                                <div id="payments_select" class="inputs-block">
                                    <?= $form->field($model, 'yandex_money')->textInput([
                                        'data-payment' => 'yandex_money',
                                        'class' => 'form-control active',
                                        'placeholder' => 'Номер кошелька',
                                        'id' => 'yandex_money',
                                        'readonly' => true,
                                    ])->label(false) ?>

                                    <?= $form->field($model, 'wmr')->textInput([
                                        'data-payment' => 'wmr',
                                        'class' => 'form-control',
                                        'placeholder' => 'Номер кошелька',
                                        'id' => 'webmoney_wmr',
                                        'readonly' => true,
                                    ])->label(false) ?>

                                    <?= $form->field($model, 'wmz')->textInput([
                                        'data-payment' => 'wmz',
                                        'class' => 'form-control',
                                        'placeholder' => 'Номер кошелька',
                                        'id' => 'webmoney_wmz',
                                        'readonly' => true,
                                    ])->label(false) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="push25"></div>
    <?php endif; ?>

    <div id="save-block">
        <div>
            <small>* - поля, обязательные для заполнения</small>
        </div>
        <div class="push10"></div>

        <input type="button" id="save-block-button" class="btn" value="Сохранить"/>
    </div>

    <div id="confirm-block" data-url="<?= Url::to(['user/settings/get-settings-code']) ?>">
        <?php if ($model->role === User::ROLE_WEBMASTER): ?>
            <?= $this->render('_sms-form', compact('model', 'form')) ?>
        <?php else: ?>
            <?= $this->render('_email-form', compact('model', 'form')) ?>
        <?php endif; ?>
    </div>

    <?php ActiveForm::end() ?>
</div>
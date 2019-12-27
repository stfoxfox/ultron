<?php

use yii\widgets\ActiveForm;
use app\widgets\topmenu\TopMenu;

/** @var $this \yii\web\View */
/** @var $model \app\models\SellerRequest */

?>

<?= TopMenu::widget() ?>

<div class="middle">
    <div class="container">
        <div class="seller-reg">
            <div class="push30"></div>
            <div class="push30 hidden-xs hidden-sm"></div>
            <div class="title-h2">Регистрация веб-мастера</div>

            <?php if (Yii::$app->session->hasFlash('seller-reg')): ?>
                <?= Yii::$app->session->getFlash('seller-reg') ?>
            <?php else: ?>
                <?php $form = ActiveForm::begin([
                    'enableClientValidation' => false,
                    'enableAjaxValidation' => true,
                    'options' => ['class' => 'rf'],
                ]) ?>

                <?= $form->field($model, 'username')->textInput([
                    'class' => 'form-control',
                ])->label('Логин *') ?>

                <div class="row">
                    <div class="col-sm-6">
                        <?= $form->field($model, 'first_name')->textInput([
                            'class' => 'form-control',
                        ])->label('Имя *') ?>
                    </div>
                    <div class="col-sm-6">
                        <?= $form->field($model, 'last_name')->textInput([
                            'class' => 'form-control',
                        ])->label('Фамилия *') ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <?= $form->field($model, 'email')->textInput([
                            'class' => 'form-control',
                        ])->label('Email *') ?>
                    </div>
                    <div class="col-sm-6">

                        <?= $form->field($model, 'phone', [
                            'template' => "{label}\n<i class=\"material-icons help-icon attention\" data-hasqtip=\"3\" aria-describedby=\"qtip-3\">announcement</i>
                        <div class=\"hide\">
                            <strong class=\"f16\">Внимание!</strong><br/>
                            На этот телефон будут приходить смс с паролем для подтверждения изменения данных в
                            личном кабинете.
                            Вводите информацию правильно!
                        </div>

                        <i class=\"material-icons help-icon\" data-hasqtip=\"3\" aria-describedby=\"qtip-3\">help</i>
                        <div class=\"hide\">
                            Вводите номер телефона в международном формате, например для России это +7xxxxxxxxxx,
                            для Украины +38xxxxxxxxxx и т.д.
                        </div>
                        <div class=\"push5\"></div>\n{input}",
                        ])->textInput([
                            'class' => 'form-control',
                            'placeholder' => '+7xxxxxxxxxx',
                        ])->label('Номер мобильного телефона *') ?>
                    </div>
                </div>

                <?= $form->field($model, 'skype')->textInput([
                    'class' => 'form-control',
                ]); ?>

                <div class="row">
                    <div class="col-sm-6">
                        <?= $form->field($model, 'password1')->passwordInput([
                            'class' => 'form-control',
                        ])->label('Пароль') ?>
                    </div>
                    <div class="col-sm-6">
                        <?= $form->field($model, 'password2')->passwordInput([
                            'class' => 'form-control',
                        ])->label('Подтвердите пароль') ?>
                    </div>
                </div>
                <div class="push25"></div>
                <div class="title-h3">Платежные реквизиты</div>
                <p style="margin-top: -20px;">(изменить в дальнейшем можно только через техническую поддержку сайта):</p>

                <?= $form->field($model, 'wmr')->textInput([
                    'class' => 'form-control',
                    'id' => 'webmoney_wmr',
                    'placeholder' => 'R____________',
                ])->label('Webmoney RUB'); ?>

                <?= $form->field($model, 'wmz')->textInput([
                    'class' => 'form-control',
                    'id' => 'webmoney_wmz',
                    'placeholder' => 'Z____________',
                ])->label('Webmoney USD'); ?>

                <?= $form->field($model, 'yandex_money')->textInput([
                    'class' => 'form-control',
                    'id' => 'yandex_money',
                    'placeholder' => '______________',
                ])->label('Yandex Деньги'); ?>

                <div class="push10"></div>

                <?= $form->field($model, 'isAgree', [
                'options' => ['class' => 'customcheck m1'],
                'template' => "{input}\n<label for=\"agreement2\">
                <i class=\"material-icons no-checked-icon\">check_box_outline_blank</i>
                <i class=\"material-icons checked-icon\">check_box</i>
                C правилами и условиями сервиса согласен
            </label><div class=\"push5\"></div>{error}
            <a href=\"#\" class=\"decoration f14\" style=\"margin-left: 30px;\">Читать правила и условия</a>",
            ])->checkbox(['class' => 'required', 'id' => 'agreement2'], false) ?>

                <div class="push25"></div>

                <!--            <div class="sms-block">-->
                <!--                <p>-->
                <!--                    Введите четырехзначный код, отправленный SMS сообщением на указанный номер телефона <b>+7(xxx)-->
                <!--                        xxx-5481</b>-->
                <!--                </p>-->
                <!--                <div class="push10"></div>-->
                <!--                <input type="text" class="form-control required" placeholder="Введите код из sms"/>-->
                <!--                <small>-->
                <!--                    * - СМС уведомления отправляются на операторы сотовой связи: МТС (Россия), Магафон (Россия) и-->
                <!--                    т.д.-->
                <!--                </small>-->
                <!--                <div class="push25"></div>-->
                <!---->
                <!--                <input type="submit" class="btn" value="Отправить"/>-->
                <!--            </div>-->

                <input type="submit" class="btn" value="Продолжить"/>

                <?php ActiveForm::end() ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="push50"></div>
</div>
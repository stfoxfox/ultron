<?php

/** @var $this \yii\web\View */
/** @var $form \yii\widgets\ActiveForm */
/** @var $model \app\models\User */

?>

<div class="sms-block">
    <p>
        Введите четырехзначный код, отправленный SMS сообщением на указанный номер телефона <b><?= $model->phone ?></b>
    </p>

    <div class="push10"></div>

    <?= $form->field($model, 'settingsCode')->textInput([
        'class' => 'form-control required',
        'placeholder' => 'Введите код из sms',
    ])->label(false) ?>

    <small>
        * - СМС уведомления отправляются на операторы сотовой связи: МТС (Россия), Магафон (Россия) и т.д.
    </small>
    <div class="push25"></div>

    <input type="submit" class="btn" value="Подтвердить">
</div>
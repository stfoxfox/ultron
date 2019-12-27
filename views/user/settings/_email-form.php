<?php

/** @var $this \yii\web\View */
/** @var $form \yii\widgets\ActiveForm */
/** @var $model \app\models\User */

?>

<div class="sms-block">
    <p>
        Введите четырехзначный код, отправленный сообщением на указанную почту  <b><?= $model->email ?></b>
    </p>

    <div class="push10"></div>

    <?= $form->field($model, 'settingsCode')->textInput([
        'class' => 'form-control required',
        'placeholder' => 'Введите код из email',
    ])->label(false) ?>

    <div class="push25"></div>

    <input type="submit" class="btn" value="Подтвердить">
</div>
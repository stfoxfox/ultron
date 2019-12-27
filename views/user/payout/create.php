<?php

use app\widgets\profileblock\ProfileBlock;
use app\widgets\topmenu\TopMenu;
use yii\widgets\ActiveForm;
use app\models\Payout;

/** @var $this \yii\web\View */
/** @var $model \app\models\User */


?>
<div class="title-h2">Запрос на выплату</div>

<?php if (Payout::availableSum(Yii::$app->user->id) == 0): ?>
    В данный момент к выплате ничего не доступно.
<?php else: ?>
    <div class="settings">
        <?php $form = ActiveForm::begin([
            'options' => ['class' => 'rf'],
            'enableClientValidation' => false,
            'enableAjaxValidation' => true,
        ]) ?>

        <?= $form->field($model, 'sum')->textInput([
            'class' => 'form-control required',
        ])->label('Сумма (р.)') ?>

        <small>Макс. допустимая сумма &mdash; <?= Payout::availableSum(Yii::$app->user->id) ?>р.
        </small>

        <div class="push10"></div>

        <?= $form->field($model, 'payment_type')->dropDownList(Payout::getPaymentTypes(Yii::$app->user->id), [
            'prompt' => 'Выберите способ выплаты',
            'class' => 'form-control required',
        ]) ?>

        <div class="push25"></div>

        <input type="submit" class="btn" value="Отправить"/>
        <?php ActiveForm::end() ?>
    </div>
<?php endif; ?>

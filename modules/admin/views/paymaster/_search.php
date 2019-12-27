<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PaymasterSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="paymaster-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'LMI_SYS_PAYMENT_ID') ?>

    <?= $form->field($model, 'LMI_PAYMENT_NO') ?>

    <?= $form->field($model, 'LMI_SYS_PAYMENT_DATE') ?>

    <?= $form->field($model, 'LMI_PAYMENT_AMOUNT') ?>

    <?= $form->field($model, 'LMI_CURRENCY') ?>

    <?php // echo $form->field($model, 'LMI_PAID_AMOUNT') ?>

    <?php // echo $form->field($model, 'LMI_PAID_CURRENCY') ?>

    <?php // echo $form->field($model, 'LMI_PAYMENT_METHOD') ?>

    <?php // echo $form->field($model, 'LMI_PAYMENT_DESC') ?>

    <?php // echo $form->field($model, 'LMI_HASH') ?>

    <?php // echo $form->field($model, 'LMI_PAYER_IDENTIFIER') ?>

    <?php // echo $form->field($model, 'LMI_PAYER_COUNTRY') ?>

    <?php // echo $form->field($model, 'LMI_PAYER_PASSPORT_COUNTRY') ?>

    <?php // echo $form->field($model, 'LMI_PAYER_IP_ADDRESS') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

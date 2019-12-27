<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Paymaster */

$this->title = $model->LMI_SYS_PAYMENT_ID;
$this->params['breadcrumbs'][] = ['label' => 'Paymasters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paymaster-view">

    <h1><?= Html::encode($this->title) ?></h1>

<!--    <p>-->
<!--        --><?//= Html::a('Delete', ['delete', 'id' => $model->LMI_SYS_PAYMENT_ID], [
//            'class' => 'btn btn-danger',
//            'data' => [
//                'confirm' => 'Are you sure you want to delete this item?',
//                'method' => 'post',
//            ],
//        ]) ?>
<!--    </p>-->

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'LMI_SYS_PAYMENT_ID',
            'LMI_PAYMENT_NO',
            'LMI_SYS_PAYMENT_DATE:datetime',
            'LMI_PAYMENT_AMOUNT',
            'LMI_CURRENCY',
            'LMI_PAID_AMOUNT',
            'LMI_PAID_CURRENCY',
            'LMI_PAYMENT_METHOD',
            'LMI_PAYMENT_DESC:ntext',
            'LMI_HASH',
            'LMI_PAYER_IDENTIFIER',
            'LMI_PAYER_COUNTRY',
            'LMI_PAYER_PASSPORT_COUNTRY',
            'LMI_PAYER_IP_ADDRESS',
        ],
    ]) ?>

</div>

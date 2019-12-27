<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PaymasterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Paymasters';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paymaster-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'LMI_SYS_PAYMENT_ID',
            'LMI_PAYMENT_NO',
            'LMI_SYS_PAYMENT_DATE',
            'LMI_PAYMENT_AMOUNT',
            'LMI_CURRENCY',
            // 'LMI_PAID_AMOUNT',
            // 'LMI_PAID_CURRENCY',
            // 'LMI_PAYMENT_METHOD',
            // 'LMI_PAYMENT_DESC:ntext',
            // 'LMI_HASH',
            // 'LMI_PAYER_IDENTIFIER',
            // 'LMI_PAYER_COUNTRY',
            // 'LMI_PAYER_PASSPORT_COUNTRY',
            // 'LMI_PAYER_IP_ADDRESS',

            [
                'class' => 'app\components\inspinia\ActionColumn',
                'template' => '{view}'
            ],
        ],
    ]); ?>
</div>

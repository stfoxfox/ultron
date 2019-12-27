<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\SellerRequestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Запросы от вебмастеров';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seller-request-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'email:email',
//            [
//                'attribute' => 'email',
//                'format' => 'email',
//                'headerOptions' => [
//                    'style' => 'width: 100px'
//                ]
//            ],
            'message:ntext',
            'skype',

            [
                'class' => 'app\components\inspinia\ActionColumn',
                'template' => '{view}{delete}'
            ],
        ],
    ]); ?>
</div>

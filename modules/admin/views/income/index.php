<?php

use app\components\inspinia\GridView;
use app\components\inspinia\Breadcrumbs;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Payout;

/* @var $this yii\web\View */
/* @var $searchModel \app\modules\admin\models\PayoutSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Выплаты';
$this->params['breadcrumbs'][] = $this->title;

?>

<?php $this->beginBlock('header') ?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2><?= Html::encode($this->title) ?></h2>
        <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
    </div>
    <div class="col-lg-4">
        <div class="title-action"></div>
    </div>
</div>
<?php $this->endBlock() ?>

<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">

            <div class="tabs-container">
                <div class="panel-body">
                    <?php \yii\widgets\Pjax::begin() ?>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => null,
                        'columns' => [
                            [
                                'class' => 'app\components\SumColumn',
                                'label' => 'Общая задолженность',
                                'attribute' => 'user.totalIncome',
                                'format' => 'currency',
                            ],
                            [
                                'class' => 'app\components\SumColumn',
                                'label' => 'Сумма hold',
                                'attribute' => 'user.holdIncome',
                                'format' => 'currency',
                            ],
                            [
                                'class' => 'app\components\SumColumn',
                                'label' => 'Сумма к выплате',
                                'attribute' => 'user.availableIncome',
                                'format' => 'currency',
                            ],
                            [
                                'attribute' => 'user.id',
                                'format' => 'raw',
                                'label' => 'ID вебмастера',
                                'value' => function ($model) {
                                    return $model->user->id;
                                },
                            ],
                            [
                                'attribute' => 'user.username',
                                'format' => 'raw',
                                'label' => 'Логин',
                                'value' => function ($model) {
                                    $link = Html::a($model->user->username, ['webmaster/view', 'id' => $model->user->id]);
                                    if ($model->user->comment) {
                                        $link .= ' <i class="fa fa-exclamation-circle" data-toggle="tooltip" data-original-title="' . $model->user->comment . '"></i>';
                                    }
                                    return $link;
                                },
                            ],
                            [
                                'label' => 'Реквизиты',
                                'attribute' => 'default_payment_system',
                                'value' => function ($model) {
                                    return Payout::getPaymentTypes($model->user->id)[$model->user->default_payment_system] ?? '';
                                },
                            ],
                            [
                                'label' => '%',
                                'attribute' => 'payout_percent',
                                'value' => function ($model) {
                                    return $model->user->incomePercent() . '%';
                                },
                            ],
                            [
                                'class' => 'app\components\inspinia\ActionColumn',
                                'template' => '{pay}',
                                'buttons' => [
                                    'pay' => function ($url, $model, $key) {
                                        if ($model->user->getAvailableIncome() <= 0) {
                                            return '';
                                        }

                                        $url = Url::to(['/admin/payout/create', 'userId' => $model->user_id]);
                                        return Html::a(Html::tag('i', '', ['class' => 'fa fa-money']), $url, [
                                            'title' => 'Выплатить',
                                            'data-pjax' => '0',
                                        ]);
                                    },
                                ],
                            ],
                        ],
                        'showFooter' => true,
                    ]); ?>

                    <?php \yii\widgets\Pjax::end() ?>
                </div>
            </div>
        </div>
    </div>
</div>
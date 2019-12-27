<?php

use app\components\inspinia\GridView;
use app\components\inspinia\Breadcrumbs;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel \app\modules\admin\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Вебмастеры';
$this->params['breadcrumbs'][] = $this->title;

?>

<?php $this->beginBlock('header') ?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2><?= Html::encode($this->title) ?></h2>
        <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
    </div>
    <div class="col-lg-4">
        <div class="title-action">
            <a href="<?= Url::to(['create']) ?>" class="btn btn-primary">Добавить
                вебмастера</a>
        </div>
    </div>
</div>
<?php $this->endBlock() ?>

<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Всего записей: <?= $dataProvider->getTotalCount() ?></h5>
                </div>
                <div class="ibox-content">

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            [
                                'attribute' => 'id',
                                'options' => [
                                    'style' => 'width: 100px;',
                                ],
                            ],
                            [
                                'attribute' => 'username',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    $link = Html::a($model->username, ['view', 'id' => $model->id]);
                                    if ($model->comment) {
                                        $link .= ' <i class="fa fa-exclamation-circle" data-toggle="tooltip" data-original-title="' . $model->comment . '"></i>';
                                    }
                                    return $link;
                                },
                                'options' => [
                                    'style' => 'width: 250px;',
                                ],
                            ],
                            'email:email',
                            [
                                'attribute' => 'created_at',
                                'format' => 'date',
                                'value' => 'created_at',
                                'filter' => \yii\jui\DatePicker::widget([
                                    'language' => 'ru',
                                    'model' => $searchModel,
                                    'attribute' => 'created_at',
                                    'dateFormat' => 'yyyy-MM-dd',
                                    'options' => [
                                        'class' => 'form-control',
                                    ],
                                ]),
                            ],
                            'goodsCount',
                            'sales_count',
                            'totalIncome:currency',
                            'holdIncome:currency',
                            'availableIncome:currency',
                            [
                                'attribute' => 'status',
                                'value' => 'displayStatus',
                                'filter' => \app\models\User::getStatuses(),
                            ],

                            [
                                'class' => 'app\components\inspinia\ActionColumn',
                                'template' => '{update} {delete}',
                                'buttons' => [
                                    'delete' => function ($url, $model, $key) {
                                        return Html::a('<i class="fa fa-trash-o"></i>', [
                                            '/admin/payout/delete'
                                        ], [
                                            'data-id' => $model->id,
                                            'class' => 'deleteBtn'
                                        ]);
                                    }
                                ],
                                'options' => [
                                    'style' => 'width: 80px;',
                                ],
                            ],
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>




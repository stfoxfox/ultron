<?php

use app\components\inspinia\GridView;
use app\components\inspinia\Breadcrumbs;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Payout;

/* @var $this yii\web\View */
/* @var $searchModel \app\modules\admin\models\PayoutSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Архив выплат';
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
                        'filterModel' => $searchModel,
                        'showFooter' => true,
                        'columns' => [
                            [
                                'attribute' => 'searchDisplayNumber',
                                'value' => 'displayNumber',
                                'label' => '№ выплаты',
                                'footer' => '<b>Итого</b>',
                            ],
                            [
                                'attribute' => 'searchWebmasterUsername',
                                'format' => 'raw',
                                'label' => 'Вебмастер',
                                'value' => function ($model) {
                                    if (isset($model->user)) {
                                        $link = Html::a($model->user->username, ['webmaster/view', 'id' => $model->user_id]);
                                        if ($model->user->comment) {
                                            $link .= ' <i class="fa fa-exclamation-circle" data-toggle="tooltip" data-original-title="' . $model->user->comment . '"></i>';
                                        }
                                        return $link;
                                    } else {
                                        return null;
                                    }
                                },
                                'options' => [
                                    'style' => 'width: 250px;',
                                ],
                            ],
                            [
                                'attribute' => 'created_at',
                                'format' => 'date',
                                'value' => 'created_at',
//                                'filter' => \yii\jui\DatePicker::widget([
//                                    'language' => 'ru',
//                                    'model' => $searchModel,
//                                    'attribute' => 'created_at',
//                                    'dateFormat' => 'yyyy-MM-dd',
//                                    'options' => [
//                                        'class' => 'form-control',
//                                    ],
//                                ]),
                                'filter' => kartik\daterange\DateRangePicker::widget([
                                    'model' => $searchModel,
                                    'attribute' => 'created_at',
                                    'useWithAddon' => false,
                                    'convertFormat' => true,
                                    'options' => [
                                        'id' => 'template-discount_date',
                                        'class' => 'form-control'
                                    ],
                                    'pluginOptions' => [
                                        'timePicker' => false,
                                        'locale' => [
                                            'format' => 'Y-m-d'
                                        ],
                                    ]
                                ])
                            ],
                            [
                                'attribute' => 'sum',
                                'format' => 'currency',
                                'filter' => Html::activeTextInput($searchModel, 'sum', [
                                    'class' => 'form-control',
                                    'placeholder' => '>=',
                                ]),
                                'footer' => '<b>' . \Yii::$app->formatter->asCurrency($searchModel->sumOfPayout) . '</b>'
                            ],
                            [
                                'attribute' => 'displayPicture',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return Html::a($model->displayPicture,
                                        \app\components\File::src($model, 'picture'), [
                                            'target' => '_blank',
                                            'data-pjax' => '0',
                                        ]);
                                },
                            ],
                            [
                                'class' => 'app\components\inspinia\ActionColumn',
                                'template' => '{delete}',
                                'buttons' => [
                                    'delete' => function ($url, $model, $key) {
                                        return Html::a('<i class="fa fa-trash-o"></i>', [
                                            '/admin/payout/delete'
                                        ], [
                                            'data-id' => $model->id,
                                            'class' => 'deleteBtn'
                                        ]);
                                    }
                                ]
                            ],
                        ],
                    ]); ?>

                    <?php \yii\widgets\Pjax::end() ?>
                </div>
            </div>
        </div>
    </div>
</div>

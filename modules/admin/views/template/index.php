<?php

use yii\helpers\ArrayHelper;
use app\components\inspinia\Breadcrumbs;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\CargoTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Товары';
$this->params['breadcrumbs'][] = $this->title;
//        var_dump("testew");die;

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
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Всего записей: <?= $dataProvider->getTotalCount() ?></h5>
                </div>
                <div class="ibox-content">

                    <?php // \yii\widgets\Pjax::begin()?>
                    <?= \richardfan\sortable\SortableGridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'sortUrl' => Url::to(['sortItem']),
                        'columns' => [
                            [
                                'attribute' => 'preview',
                                'value' => function ($model) {
                                    return Html::a($model->displayPicture,
                                        ['/template/view', 'id' => $model->id],
                                        [
                                            'target' => '_blank',
                                            'data-pjax' => '0',
                                        ]);
                                },
                                'format' => 'raw'
                            ],
                            [
                                'attribute' => 'searchArticle',
                                'format' => 'raw',
                                'label' => 'Артикул',
                                'value' => function ($model) {
                                    $link = Html::a($model->displayArticle, ['update', 'id' => $model->id]);
                                    if ($model->comment) {
                                        $link .= ' <i class="fa fa-exclamation-circle" data-toggle="tooltip" data-original-title="' .
                                            $model->displayArticle . '"></i>';
                                    }
                                    return $link;
                                },
                            ],
                            [
                                'attribute' => 'title',
                                'format' => 'raw',
                                'label' => 'Название',
                                'value' => function ($model) {
                                    $link = Html::a(Html::encode($model->title), ['update', 'id' => $model->id]);
                                    if ($model->comment) {
                                        $link .= ' <i class="fa fa-exclamation-circle" data-toggle="tooltip" data-original-title="' .
                                            Html::encode($model->comment) . '"></i>';
                                    }
                                    if($model->categories)
                                    {
                                        $categoriesString = '';
                                        foreach ($model->categories as $category){
                                            $categoriesString .= '<span class="badge badge-light">'.$category->title.'</span> &nbsp;';
                                        }
                                        $link .= "<br/>".$categoriesString;
                                    }
                                    if($model->tags)
                                    {
                                        $tagsString = '';
                                        foreach ($model->tags as $tag){
                                            $tagsString .= '<span class="badge badge-success"># '.$tag->title.'</span> &nbsp;';
                                        }
                                        $link .= "<br/>".$tagsString;
                                    }

                                    return $link;
                                },
                            ],
                            [
                                'attribute' => 'searchType',
                                'label' => 'Тип',
                                'format' => 'text',
                                'value' => function ($model) {
                                    return $model->type->short_title ?? null;
                                },
                                'filter' => \app\models\Type::getTypes(),
                            ],
                            [
                                'attribute' => 'searchUsername',
                                'label' => 'Вебмастер',
                                'value' => 'user.username',
                            ],
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
                            [
                                'attribute' => 'price',
                                'format' => 'currency',
                                'filter' => Html::activeTextInput($searchModel, 'price', [
                                    'class' => 'form-control',
                                    'placeholder' => '>=',
                                ]),
                            ],
                            [
                                'attribute' => 'new_price',
                                'format' => 'currency',
                                'filter' => Html::activeTextInput($searchModel, 'new_price', [
                                    'class' => 'form-control',
                                    'placeholder' => '>=',
                                ]),
                            ],
                            [
                                'attribute' => 'discount_date',
                                'format' => 'date',
                                'label' => 'Акция',
                                'value' => 'discount_date',
                                'filter' => \yii\jui\DatePicker::widget([
                                    'language' => 'ru',
                                    'model' => $searchModel,
                                    'attribute' => 'discount_date',
                                    'dateFormat' => 'yyyy-MM-dd',
                                    'options' => [
                                        'class' => 'form-control',
                                    ],
                                ]),
                            ],
                            [
                                'attribute' => 'sales_count',
                                'filter' => Html::activeTextInput($searchModel, 'sales_count', [
                                    'class' => 'form-control',
                                    'placeholder' => '>=',
                                ]),
                            ],
                            [
                                'attribute' => 'searchStatus',
                                'value' => 'displayStatus',
                                'label' => 'Статус',
                                'filter' => \app\models\Template::getStatuses(),
                            ],
                            [
                                'attribute' => 'searchModerateStatus',
                                'value' => 'displayModerateStatus',
                                'label' => 'Модерация',
                                'filter' => \app\models\Template::getModerateStatuses(),
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
                                ]
                            ],
                        ],
                    ]); ?>
                    <?php // \yii\widgets\Pjax::end() ?>

                </div>
            </div>
        </div>
    </div>
</div>




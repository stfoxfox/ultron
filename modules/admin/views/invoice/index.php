<?php

use app\components\inspinia\GridView;
use app\components\inspinia\Breadcrumbs;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\components\ViewHelper;

/* @var $this yii\web\View */
/* @var $searchModel \app\modules\admin\models\InvoiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//vd($dataProvider->getModels());

$this->title = 'Продажи';
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
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <div class=" col-lg-5">
                        <h5>Всего записей: <?= $dataProvider->getTotalCount() ?></h5>
                    </div>
                    <div class="col-lg-7 filter-date">
                        <? ActiveForm::begin([
                            'options' => ['class' => 'form-inline'],
                            'method' => 'GET'
                        ]) ?>
                        <?= kartik\daterange\DateRangePicker::widget([
                            'model' => $searchModel,
                            'attribute' => 'searchInvoiceDate',
                            'useWithAddon' => false,
                            'convertFormat' => true,
                            'options' => [
                                'id' => 'template-discount_date',
                                'class' => 'form-control',
                                'placeholder' => 'Поиск по дате',
                                'value' => Yii::$app->request->get('InvoiceSearch')['searchInvoiceDate']
                            ],
                            'pluginOptions' => [
                                'timePicker' => false,
                                'locale' => [
                                    'format' => 'Y-m-d'
                                ],
                            ]
                        ]) ?>

                        <?= Html::submitButton('Искать', ['class' => 'btn btn-info']) ?>

                        <? ActiveForm::end() ?>
                    </div>

                </div>
                <div class="ibox-content">

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => null,
                        'columns' => [
                            [
                                'attribute' => 'searchDisplayNumber',
                                'label' => '#',
                                'value' => 'invoice.id',
                                'options' => [
                                    'style' => 'width: 50px;',
                                ],
                            ],
                            [
                                'attribute' => 'searchTemplateDisplayArticle',
                                'format' => 'raw',
                                'label' => 'Артикул',
                                'value' => function ($model) {
                                    return Html::a($model->template->displayArticle, ['/admin/template/update', 'id' => $model->template->id]);
                                },
                            ],
                            [
                                'attribute' => 'searchTemplateDisplayTitle',
                                'format' => 'raw',
                                'label' => 'Название шаблона',
                                'value' => function ($model) {
                                    $link = Html::a(Html::encode($model->template->title), ['/admin/template/update', 'id' => $model->template->id]);
                                    if ($model->template->comment) {
                                        $link .= ' <i class="fa fa-exclamation-circle" data-toggle="tooltip" data-original-title="' .
                                            Html::encode($model->template->comment) . '"></i>';
                                    }
                                    return $link . "<br>" . ViewHelper::addList($model->invoiceTemplateOptions, $model->invoiceTemplateServices, 'title');
                                },
                            ],
                            [
                                'attribute' => 'invoice.paid_at',
                                'format' => 'date',
                                'label' => 'Дата',
                                'value' => 'invoice.paid_at',
                            ],
                            [
                                'label' => 'Вебмастер',
                                'attribute' => 'searchWebmasterUsername',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    if (!$model->template->user){
                                        return "пользователь удален";
                                    }
                                    $link = Html::a($model->template->user->username, ['/admin/webmaster/view', 'id' => $model->template->user->id]);
                                    if ($model->template->user->comment) {
                                        $link .= ' <i class="fa fa-exclamation-circle" data-toggle="tooltip" data-original-title="' . $model->template->user->comment . '"></i>';
                                    }
                                    return $link;
                                },
                            ],
                            [
                                'label' => 'Покупатель',
                                'attribute' => 'searchCustomerUsername',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    if (!$model->invoice->user){
                                        return "пользователь удален";
                                    }
                                    $link = Html::a($model->invoice->user->username, ['/admin/user/view', 'id' => $model->invoice->user->id]);
                                    if ($model->invoice->user->comment) {
                                        $link .= ' <i class="fa fa-exclamation-circle" data-toggle="tooltip" data-original-title="' . $model->invoice->user->comment . '"></i>';
                                    }
                                    return $link;
                                },
                            ],
                            [
                                'attribute' => 'price',
                                'value' => function ($model) {
                                    return $model->price . " руб<br>" . ViewHelper::addList($model->invoiceTemplateOptions, $model->invoiceTemplateServices, 'price', ' руб');
                                },
                                'format' => 'html',
                                'headerOptions' => ['width' => 80],
                            ],
                            [
                                'label' => 'Выплата(%)',
                                'value' => function ($model) {
//                                    if ($model->income == null || $model->income->sum == 0 || $model->price == 0) {
//                                        return null;
//                                    }
                                    return $model->template->user->incomePercent();
                                },
                            ],
                            [
                                'label' => 'Выплата',
                                'value' => 'income.sum',
                                'format' => 'currency',
                            ],
                            [
                                'label' => 'Прибыль',
                                'format' => 'currency',
                                'value' => function ($model) {
                                    if ($model->income == null || $model->income->sum == 0 || $model->price == 0) {
                                        return null;
                                    }

                                    return $model->price - $model->income->sum;
                                },
                            ],
                            'invoice.displayStatus',
                        ],
                    ]); ?>

                </div>
            </div>
        </div>
    </div>
</div>
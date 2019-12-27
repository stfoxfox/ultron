<?php

use yii\helpers\Url;
use yii\helpers\Html;
use app\components\inspinia\Breadcrumbs;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Просмотр вебмастера';
$this->params['pageHeader'] = $this->title;
$this->params['breadcrumbs'][] = ['label' => 'Вебмастеры', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<?php $this->beginBlock('header') ?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2><?= Html::encode($this->title) ?></h2>
        <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
    </div>
    <div class="col-lg-6">
        <div class="title-action">
            <a href="<?= Url::to(['index']) ?>" class="btn btn-white">&larr;
                Вернуться назад</a>
            <a href="<?= Url::to(['update', 'id' => $model->id]) ?>" class="btn btn-info">Редактировать</a>
            <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Вы действительно хотите безвозвратно удалить этого вебмастера?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>
    </div>
</div>
<?php $this->endBlock() ?>

<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab-1" aria-expanded="true">Общие сведения</a></li>
                    <li class=""><a data-toggle="tab" href="#tab-2" aria-expanded="false">Товары</a></li>
                    <li class=""><a data-toggle="tab" href="#tab-3" aria-expanded="false">Продажи</a></li>
                    <li class=""><a data-toggle="tab" href="#tab-4" aria-expanded="false">Выплаты</a></li>
                </ul>
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane active">
                        <div class="panel-body">
                            <?= DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    'id',
                                    'username',
                                    'email:email',
                                    'created_at:date',
                                    'last_visit:datetime',
                                    'displayStatus',
                                ],
                            ]) ?>
                        </div>
                    </div>
                    <div id="tab-2" class="tab-pane">
                        <div class="panel-body">
                            <?php \yii\widgets\Pjax::begin() ?>
                            <?= \yii\grid\GridView::widget([
                                'dataProvider' => $templateDataProvider,
                                'columns' => [
                                    'id',
                                    [
                                        'attribute' => 'title',
                                        'value' => function ($model) {
                                            $title = $model->title;
                                            if($model->categories)
                                            {
                                                $categoriesString = '';
                                                foreach ($model->categories as $category){
                                                    $categoriesString .= '<span class="badge badge-light">'.$category->title.'</span> &nbsp;';
                                                }
                                                $title .= "<br/>".$categoriesString;
                                            }
                                            if($model->tags)
                                            {
                                                $tagsString = '';
                                                foreach ($model->tags as $tag){
                                                    $tagsString .= '<span class="badge badge-success"># '.$tag->title.'</span> &nbsp;';
                                                }
                                                $title .= "<br/>".$tagsString;
                                            }
                                            return $title;
                                        },
                                        'format' => 'raw',
                                    ],
                                    'created_at:date',
                                    'displayStatus',
                                    'displayModerateStatus',
                                    'sales_count',
                                    'price:currency',
                                ],
                            ]) ?>
                            <?php \yii\widgets\Pjax::end() ?>
                        </div>
                    </div>
                    <div id="tab-3" class="tab-pane">
                        <div class="panel-body">
                            <?php \yii\widgets\Pjax::begin() ?>
                            <?= \yii\grid\GridView::widget([
                                'dataProvider' => $invoiceDataProvider,
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
                                        'label' => 'Артукул',
                                        'value' => 'template.displayArticle',
                                    ],
                                    [
                                        'label' => 'Название шаблона',
                                        'attribute' => 'searchTemplateDisplayTitle',
                                        'value' => function ($model) {
                                            $title = $model->template->title;
                                            if($model->template->categories)
                                            {
                                                $categoriesString = '';
                                                foreach ($model->template->categories as $category){
                                                    $categoriesString .= '<span class="badge badge-light">'.$category->title.'</span> &nbsp;';
                                                }
                                                $title .= "<br/>".$categoriesString;
                                            }
                                            if($model->template->tags)
                                            {
                                                $tagsString = '';
                                                foreach ($model->template->tags as $tag){
                                                    $tagsString .= '<span class="badge badge-success"># '.$tag->title.'</span> &nbsp;';
                                                }
                                                $title .= "<br/>".$tagsString;
                                            }
                                            return $title;
                                        },
                                        'format' => 'raw',
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
                                        'value' => 'template.user.username',
                                    ],
                                    [
                                        'label' => 'Покупатель',
                                        'attribute' => 'searchCustomerUsername',
                                        'value' => 'invoice.user.username',
                                    ],
                                    'price:currency:Цена',
                                    [
                                        'label' => 'Выплата(%)',
                                        'value' => function ($model) {
                                            if ($model->income == null || $model->income->sum == 0 ||$model->price == 0) {
                                                return null;
                                            }
                                            return round($model->income->sum / $model->price * 100);
                                        },
                                    ],
                                    [
                                        'label' => 'Выплата',
                                        'value' => 'income.sum',
                                        'format'=>'currency',
                                    ],
                                    [
                                        'label' => 'Прибыль',
                                        'format'=>'currency',
                                        'value' => function ($model) {
                                            if ($model->income == null || $model->income->sum == 0 ||$model->price == 0) {
                                                return null;
                                            }
                                            return $model->price - $model->income->sum;
                                        },
                                    ],
                                    'invoice.displayStatus',
                                ],
                            ]) ?>
                            <?php \yii\widgets\Pjax::end() ?>
                        </div>
                    </div>
                    <div id="tab-4" class="tab-pane">
                        <div class="panel-body">
                            <?php \yii\widgets\Pjax::begin() ?>
                            <?= \yii\grid\GridView::widget([
                                'dataProvider' => $payoutDataProvider,
                                'columns' => [
                                    [
                                        'attribute' => 'id',
                                        'label' => '№ выплаты',
                                        'value' => function ($model) {
                                            return '#' . $model->displayNumber;
                                        },
                                    ],
                                    'sum:currency',
                                    'displayPicture:raw',
                                    'comment',
                                ],
                            ]) ?>
                            <?php \yii\widgets\Pjax::end() ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

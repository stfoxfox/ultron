<?php

use yii\helpers\Url;
use yii\helpers\Html;
use app\components\inspinia\Breadcrumbs;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Просмотр пользователя';
$this->params['pageHeader'] = $this->title;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
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
                    'confirm' => 'Вы действительно хотите безвозвратно удалить этого пользователя?',
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
                    <li class=""><a data-toggle="tab" href="#tab-2" aria-expanded="false">Покупки</a></li>
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
                                    'displayStatus',
                                    'purchases_count',
                                    [
                                        'label' => 'Сумма покупок',
                                        'format' => 'currency',
                                        'value' => function ($model) {
                                            return $model->getInvoicesSum();
                                        },
                                    ],
                                ],
                            ]) ?>
                        </div>
                    </div>
                    <div id="tab-2" class="tab-pane">
                        <div class="panel-body">
                            <?php \yii\widgets\Pjax::begin() ?>
                            <?= \yii\grid\GridView::widget([
                                'dataProvider' => $dataProvider,
                                'summary' => '',
                                'columns' => [
                                    [
                                        'attribute' => 'invoice.id',
                                        'value' => 'invoice.displayNumber',
                                        'label' => '№ платежа',
                                    ],
                                    'invoice.created_at:date',
                                    [
                                        'attribute' => 'template.title',
                                        'format' => 'raw',
                                        'value' => function ($mode) {
                                            return Html::a(Html::encode($mode->template->title), ['/admin/template/update', 'id' => $mode->template_id]);
                                        },
                                    ],
                                    [
                                        'attribute' => 'template.displayArticle',
                                        'format' => 'raw',
                                        'value' => function ($mode) {
                                            return Html::a('#' . Html::encode($mode->template->displayArticle), ['/admin/template/update', 'id' => $mode->template_id]);
                                        },
                                    ],
                                    'template.user.username:raw:Автор',
                                    'price:currency:Цена',
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

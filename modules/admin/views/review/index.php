<?php

use app\components\inspinia\GridView;
use app\components\inspinia\Breadcrumbs;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Отзывы';
$this->params['breadcrumbs'][] = $this->title;

?>

<?php $this->beginBlock('header') ?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2><?= Html::encode($this->title) ?></h2>
        <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
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
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            [
                                'label' => 'Продукт',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return Html::a($model->template->title, $model->template->getHtmlLink(), [
                                        'target' => '_blank'
                                    ]);
                                },
                            ],

                            [
                                'label' => 'Пользователь',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    if ($model->author) {
                                        return Html::a($model->author->username, $model->author->getUserRoute());
                                    }
                                    return null;
                                },
                            ],
                            'content',
                            'created_at:date',
                            [
                                'class' => 'app\components\inspinia\ActionColumn',
                                'template' => '{update} {delete}',
                            ],
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>




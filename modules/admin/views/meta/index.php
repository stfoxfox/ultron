<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\components\inspinia\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\MetaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Метатеги';
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
                </div>
                <div class="ibox-content">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                //            'id',
                            'route',
                            'title',
                            'description:ntext',
                            'keywords:ntext',
                            'tags:ntext',

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
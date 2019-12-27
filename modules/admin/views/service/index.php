<?php

use app\components\inspinia\GridView;
use app\components\inspinia\Breadcrumbs;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\CargoTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Дополнительные услуги';
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
            <a href="<?= Url::to(['create']) ?>" class="btn btn-primary">Добавить услугу</a>
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
                        'columns' => [
                            'title',
                            'price:currency',
                            'is_required:boolean',

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




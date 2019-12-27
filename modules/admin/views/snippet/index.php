<?php

use app\components\inspinia\GridView;
use app\components\inspinia\Breadcrumbs;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\GallerySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Сниппеты';
$this->params['breadcrumbs'][] = $this->title;

?>

<?php $this->beginBlock('header') ?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
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
                            'id',
                            'key',
                            'description',

                            [
                                'class' => 'app\components\inspinia\ActionColumn',
                                'template' => '{update}',
                            ],
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>




<?php

use app\components\inspinia\GridView;
use app\components\inspinia\Breadcrumbs;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use app\modules\admin\FavoriteAsset;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Slider */
/* @var $dataProvider yii\data\ActiveDataProvider */

FavoriteAsset::register($this);

$this->title = 'Рекомендованное';
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

            <!-- <a href="<?php //Url::to(['create']) 
                            ?>" class="btn btn-primary">Добавить -->
            <!-- рекомендованный товар</a> -->
        </div>
    </div>
</div>
<?php $this->endBlock() ?>


<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <div class="col-lg-5">
                        <h5>Всего записей: <?= $dataProvider->getTotalCount() ?></h5>
                    </div>
                    <div class="favorite-template-form-block">
                        <?php $form = ActiveForm::begin([
                            'id' => 'page-form',
                            'options' => ['class' => 'form-inline'],
                        ]); ?>
                        <?= $form->field($favoriteTemplate, 'template_id')->widget(Select2::classname(), [
                            'data' => $templates,
                            'options' => ['placeholder' => 'Выберете товар ... '],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label(false);?>    

                        <?= Html::submitButton("Добавить", ['class' => 'btn btn-info', 'id' => 'favorite-template-save'])?>
                        <?php ActiveForm::end()?>
                    </div>
                </div>
                
                <div class="ibox-content">
                    <?php Pjax::begin(['id' => 'some_pjax_id']) ?>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'attribute' => 'displayArticle',
                                'value' => function ($favoriteTemplate) {
                                    return $favoriteTemplate->template->displayArticle;
                                },
                                'label' => 'Артикул'
                            ],
                            [
                                'attribute' => 'title',
                                'value' => function ($favoriteTemplate) {
                                    return $favoriteTemplate->template->title;
                                },
                                'label' => 'Название'
                            ],
                            [
                                'class' => 'app\components\inspinia\ActionColumn',
                                'template' => '{delete}',
                            ],
                        ],
                    ]); ?>
                    <?php Pjax::end() ?>
                </div>
            </div>
        </div>
    </div>
</div>

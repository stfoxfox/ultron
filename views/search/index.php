<?php

use app\widgets\topmenu\TopMenu;
use yii\helpers\Url;
use yii\widgets\ListView;
use app\widgets\categories\Categories;
use yii\helpers\Html;

/** @var $this \yii\web\View */
/** @var $searchModel \app\models\search\TemplateSearch */
/** @var $dataProvider \yii\data\ActiveDataProvider */
/** @var $searchModelFull \app\models\search\TemplateSearch */
/** @var $dataProviderFull \yii\data\ActiveDataProvider */
/** @var $search string */

?>

<?= TopMenu::widget() ?>

<div class="middle">
    <div class="push15"></div>
    <div class="breadcrumbs-wrapper">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="<?= Url::home() ?>">Главная</a></li>
                <?php if ($searchModel->findType() && !$searchModel->category): ?>
                    <i class="material-icons">navigate_next</i>
                    <li class="active"><?= $searchModel->findType()->title; ?></li>
                <?php elseif (!$searchModel->findType() && $searchModel->category): ?>
                    <i class="material-icons">navigate_next</i>
                    <li>
                        <?= Html::encode($searchModel->categoryModel->title) ?>
                    </li>
                <?php elseif ($searchModel->findType() && $searchModel->category): ?>
                    <i class="material-icons">navigate_next</i>
                    <li class="active">
                        <?= Html::a($searchModel->findType()->title, ['/template/index', 'alias' => $searchModel->findType()->alias]) ?>
                    </li>
                    <i class="material-icons">navigate_next</i>
                    <li>
                        <?= \yii\helpers\Html::encode($searchModel->categoryModel->title) ?>
                    </li>
                <?php else: ?>
                    <i class="material-icons">navigate_next</i>
                    <li class="active">Все шаблоны</li>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <div class="push20"></div>

    <div class="catalog">
        <div class="container">
            <?php if ($searchModel->findType()): ?>
                <h1><?= $searchModel->findType()->title ?></h1>
                <div class="subtitle gray">
                    <?= $searchModel->findType()->description ?>
                </div>
            <?php else: ?>
                <h1>Все шаблоны</h1>
                <div class="subtitle gray">
                    Создайте сайт на основе адаптивных шаблонов от Ultron
                </div>
            <?php endif; ?>

            <hr/>

            <div class="push15"></div>

            <div class="row">
                <div class="col-md-4 col-lg-3">
                    <?= Categories::widget([
                        'templates' => $dataProviderFull->getModels()
                    ]) ?>
                    <div class="col-xs-7">
                        <a href="/template" class="btn btn-navy">
                            Очистить поиск
                        </a>
                    </div>
                </div>
                <div class="col-md-8 col-lg-9">
                    <div class="main-column">
                        <div class="top-filter f14 roboto">
                            <?php if($search):?>
                            <div class="row">
                                <div class="col-sm-10">
                                    <span class="weight600 black">Результаты поиска:</span>
                                    <?php foreach (explode(' ', $search) as $link):?>
                                        <a href="<?=Url::to(['/search/index', 'search'=>$link])?>"><?=$link?></a>
                                    <?php endforeach;?>
                                </div>
                            </div>
                            <?php endif?>
                            <div class="row">
                                <div class="col-sm-10">
                                    <div id="mse2_sort" class="top-filter-box">
                                        <span class="weight600 black">Сортировать по:</span>
                                        <br class="visible-xs visible-sm visible-md"/>

                                        <?= $dataProvider->sort->link('price', [
                                            'label' => 'цене',
                                            'class' => 'sort',
                                        ]) ?>

                                        <?= $dataProvider->sort->link('created_at', [
                                            'label' => 'дате добавления',
                                            'class' => 'sort',
                                        ]) ?>

                                        <?= $dataProvider->sort->link('rating', [
                                            'label' => 'популярности',
                                            'class' => 'sort',
                                        ]) ?>

                                        <?= $dataProvider->sort->link('sales_count', [
                                            'label' => 'количеству продаж',
                                            'class' => 'sort',
                                        ]) ?>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="push20"></div>

                        <div class="products">
                            <div class="row">
                                <?= ListView::widget([
                                    'itemView' => '_index-item-view',
                                    'dataProvider' => $dataProvider,
                                    'summary' => '',
                                    'emptyText' => 'По вашему запросу ничего не найдено.',
                                ]) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="push50"></div>
</div>
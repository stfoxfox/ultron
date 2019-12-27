<?php

use app\widgets\topmenu\TopMenu;
use yii\helpers\Url;
use yii\widgets\ListView;

/** @var $this \yii\web\View */
/** @var $model \app\models\Template */

?>

<?= TopMenu::widget() ?>

<div class="middle">
    <div class="push15"></div>
    <div class="breadcrumbs-wrapper">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="<?= Url::home() ?>">Главная</a></li>
                <i class="material-icons">navigate_next</i>
                <li class="active">Все новости</li>
            </ul>
        </div>
    </div>

    <div class="push20"></div>

    <div class="product-container">
        <div class="container">
            <h1>Все новости</h1>
            <hr/>
            <div class="push15"></div>

            <div class="index-news-body">
                <div class="row">
                    <?= ListView::widget([
                        'itemView' => '_item-view',
                        'dataProvider' => $dataProvider,
                        'summary' => '',
                    ]) ?>
                </div>
            </div>

        </div>
    </div>

    <div class="push50"></div>
</div>
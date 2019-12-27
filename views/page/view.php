<?php

use app\widgets\topmenu\TopMenu;
use yii\helpers\Url;
use yii\helpers\Html;

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
                <li class="active"><?= Html::encode($model->title) ?></li>
            </ul>
        </div>
    </div>
    <div class="push20"></div>

    <div class="container">
        <div class="text-page-container">
            <h1><?= Html::encode($model->title) ?></h1>
            <hr/>
            <div class="push15"></div>

            <div class="row">
                <div class="col-xs-12">
				<?= $model->content ?>
				</div>
            </div>
        </div>
    </div>

    <div class="push50"></div>
</div>
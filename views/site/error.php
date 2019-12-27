<?php

use app\widgets\topmenu\TopMenu;
use yii\helpers\Url;
use yii\helpers\Html;

/** @var $this \yii\web\View */
/** @var $model \app\models\Template */

?>

<?= TopMenu::widget() ?>
<?//= nl2br(Html::encode($message)) ?>
<div class="middle">
    <div class="push15"></div>
    <div class="breadcrumbs-wrapper">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="<?= Url::home() ?>">Главная</a></li>
                <i class="material-icons">navigate_next</i>
                <li class="active">Ошибка 404</li>
            </ul>
        </div>
    </div>
    <div class="push20"></div>

    <div class="product-container">
        <div class="container">
            <h1>Ошибка 404</h1>
            <hr/>
            <div class="push15"></div>

            <div class="row">
                К сожалению, запрошенная страница не найдена. <br> <br>

                Это могло произойти по следующим причинам: <br> <br>

                Страница перемещена или переименована. <br>
                Страница больше не существует на этом сайте. <br>
                URL не соответствует действительности.  <br> <br>
                <a href="<?= Url::home() ?>">&larr; Вернуться на главную</a>
            </div>
        </div>
    </div>

    <div class="push50"></div>
</div>


<?php

use app\widgets\topmenu\TopMenu;
use yii\helpers\Url;
use yii\helpers\Html;
use app\components\File;

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
                <li><a href="<?= Url::to(['news/index']) ?>">Все новости</a></li>
                <i class="material-icons">navigate_next</i>
                <li class="active"><?= Html::encode($model->title) ?></li>
            </ul>
        </div>
    </div>

    <div class="push20"></div>

    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="news-page-container">
                    <h1>
                        <?= Html::encode($model->title) ?></h1>
                    <hr/>
                    <div class="push15"></div>

                    <div class="page-date">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        <?= Yii::$app->formatter->asDate($model->created_at) ?>
                    </div>
                    <div class="push15"></div>

                    <div class="page-img">
                        <img src="<?= File::src($model, 'picture') ?>" alt="<?= Html::encode($model->title) ?>">
                    </div>
                    <div class="push30"></div>

                    <div class="content">
                        <?= $model->content ?>
                    </div>


                    <div class="push30"></div>
                    <script type="text/javascript">
                        (function() {
                            if (window.pluso)if (typeof window.pluso.start == "function") return;
                            if (window.ifpluso==undefined) { window.ifpluso = 1;
                                var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
                                s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true;
                                s.src = ('https:' == window.location.protocol ? 'https' : 'http')  + '://share.pluso.ru/pluso-like.js';
                                var h=d[g]('body')[0];
                                h.appendChild(s);
                            }}
                        )();
                    </script>
                    <div class="pluso" data-background="none;" data-options="medium,square,line,horizontal,nocounter,sepcounter=1,theme=14" data-services="facebook,vkontakte,twitter,pinterest"></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="news-page-aside">
                    <div class="push30 hidden-md hidden-lg hidden-xlg"></div>
                    <a target="_new" href="https://timeweb.com/ru/?i=31157"><img style="width:100%; border: 2px solid #f3f9fc;" src="/images/timeweb.png"></a>
                </div>
            </div>
        </div>
    </div>

    <div class="push50"></div>
</div>
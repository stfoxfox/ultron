<?php

/** @var $models \app\models\News[] */

use yii\helpers\Url;
use app\components\File;

?>

<div class="index-news-wrapper">
    <div class="container">
        <div class="index-news">
            <div class="index-news-header">
                <div class="push35"></div>
                <div class="row no-padding">
                    <div class="col-xs-5">
                        <div class="title-h1 weight900">Новости</div>
                    </div>
                    <div class="col-xs-7 text-right">
                        <div class="push5 visible-xs"></div>
                        <div class="push15 hidden-xs"></div>
                        <a href="<?= Url::to(['news/index']) ?>" class="dotted">Все новости</a>
                    </div>
                </div>
                <div class="push3"></div>
            </div>
            <div class="index-news-body">
                <div class="row">
                    <?php foreach ($models as $model): ?>
                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <div class="news-element">
                                <a href="<?= Url::to(['news/view', 'id' => $model->id]) ?>" class="absolute"></a>
                                <div class="img-wrapper hidden-xs">
                                    <div class="element-img"
                                         style="background: url(<?= File::src($model, 'picture') ?>) 50% 50% no-repeat; background-size: cover;"></div>
                                </div>
                                <div class="element-content">
                                    <div class="date gray f13">
                                        <noindex><i class="material-icons">date_range</i></noindex> <?= Yii::$app->formatter->asDate($model->created_at, 'dd MMM, yyyy') ?>
                                        <div class="push10"></div>
                                    </div>
                                    <div class="text">
                                        <div class="table">
                                            <div class="table-cell weight600">
                                                <?= \yii\helpers\Html::encode($model->title) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="push15"></div>
                                    <a href="<?= Url::to(['news/view', 'id' => $model->id]) ?>" class="more">Подробнее
                                        <noindex><i class="material-icons">navigate_next</i></a></noindex>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="push20"></div>
    </div>
</div>

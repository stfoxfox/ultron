<?php

use yii\helpers\Url;
use app\components\File;

?>

<div class="col-sm-6 col-md-4 col-lg-3">
    <div class="news-element">
        <a href="<?= Url::to(['news/view', 'id' => $model->id]) ?>" class="absolute"></a>
        <div class="img-wrapper">
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
                <noindex><i class="material-icons">navigate_next</i></noindex></a>
        </div>
    </div>
</div>
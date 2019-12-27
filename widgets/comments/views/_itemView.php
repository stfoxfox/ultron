<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var \app\models\Comment $model */

?>

<div class="element relative">
    <div class="rev-name">
        <span class="bold" style="margin-right: 10px;">
            <?= Html::encode($model->getDisplayName()) ?>
        </span>
        <br class="visible-xs"><span
                class="date gray f13"><?= Yii::$app->formatter->asDate($model->created_at, 'dd MMM, yyyy') ?></span><br
                class="visible-xs">
        <div class="rev-rating">
            <div class="ec-stars test">
                <? for ($i = 1; $i < 6; $i++): ?>
                <i class="material-icons" title="<?=$i?>">star_border</i>
                <? endfor ?>
                <span style="width: <?= $model->getScorePercent() ?>%">
                    <i class="material-icons">star</i>
                    <i class="material-icons">star</i>
                    <i class="material-icons">star</i>
                    <i class="material-icons">star</i>
                    <i class="material-icons">star</i>
                </span>
            </div>
        </div>
    </div>
    <div class="push5"></div>
    <div class="text">
        <?= nl2br(Html::encode($model->message)) ?>
    </div>

    <?php if ($model->answer): ?>
        <div class="push15"></div>
        <div class="text reply-text">
            <div class="bold"><a href="#">Ultron</a></div>
            <?= $model->answer ?>
        </div>
    <?php endif ?>

    <div class="push15"></div>
</div>
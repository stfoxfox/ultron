<?php

use app\widgets\comments\Comments;
use app\widgets\review\Reviews;
use yii\helpers\Html;

/** @var $this \yii\web\View */
/** @var $model \app\models\Template */

?>

<div class="row">
    <div class="col-md-8 custom">
        <div class="section">
            <div class="mobile-tab-header">Описание</div>
            <ul class="tabs">
                <li class="current">Описание</li>
                <?php if ($model->features): ?>
                    <li>Характеристики</li>
                <?php endif; ?>
                <?php if ($model->version_history): ?>
                    <li>История версий</li>
                <?php endif; ?>
                <li>
                    Комментарии
                    <?= $model->commentsCount > 0 ? '<span class="rev-counter">(' . $model->commentsCount . ')</span>' : '' ?>
                </li>
                <li>
                    Вопросы автору
                    <?= $model->reviewsCount > 0 ? '<span class="rev-counter">(' . $model->reviewsCount . ')</span>' : '' ?>
                </li>
            </ul>
            <div class="push30"></div>
            <div class="box visible">
                <div class="content">
                    <?php if (!$model->description): ?>
                        <p>Описание отсутствует.</p>
                    <?php else: ?>
                        <div itemprop="description"><?= $model->description ?></div>
                    <?php endif; ?>
                </div>
            </div>
            <?php if ($model->features): ?>
                <div class="box">
                    <div class="content">
                        <?= nl2br(Html::encode($model->features)) ?>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ($model->version_history): ?>
                <div class="box">
                    <div class="content">
                        <?= nl2br(Html::encode($model->version_history)) ?>
                    </div>
                </div>
            <?php endif; ?>
            <div class="box">
                <?= Comments::widget([
                    'template' => $model,
                ]) ?>
            </div>
            <div class="box box_reviews" data-url="<?=\yii\helpers\Url::to(['/review/index', 'template_id'=>$model->id])?>">
<!--                Виджет временно не работает. Задавайте вопросы через техподдержку сайта на email <a href="mailto:support@ultron.pro">support@ultron.pro</a>-->
                <?= Reviews::widget([
                    'model' => $model,
                    'jsOptions' => [
                        'offset' => 80
                    ]
                ])  ?>
            </div>
        </div>
    </div>
</div>
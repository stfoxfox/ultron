<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var $this \yii\web\View */
/** @var $model \app\models\Template */

?>

<div class="lk-table-tr">
    <div class="row min">
        <div class="col-sm-3  col-xlg-3">
            <div class="row min">
                <div class="col-sm-5">
                    <div class="element element-article">
                        <b class="visible-xs-inline">Артикул:</b> #<?= $model->getDisplayArticle() ?>
                    </div>
                </div>
                <div class="col-sm-7">
                    <div class="element element-date">
                        <b class="visible-xs-inline">Дата:</b> <?= Yii::$app->formatter->asDate($model->created_at) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-9  col-xlg-9">
            <div class="row min">
                <div class="col-sm-6 col-xlg-6">
                    <div class="element element-title">
                        <b class="visible-xs-inline">Шаблон:</b>
                        <a href="<?= Url::to(['template/view', 'id' => $model->id]) ?>" class="decoration"
                           title="Перейти на страницу шаблона"><?= Html::encode($model->title) ?></a>
                    </div>
                </div>
                <div class="col-sm-2 col-xlg-2">
                    <div class="element element-price">
                        <b class="visible-xs-inline">Цена:</b> <?= $model->price ?> р.
                    </div>
                </div>
                <div class="col-sm-2 col-xlg-2">
                    <div class="element element-price" <?= ($model->new_price && !$model->isDiscountPeriod() && $model->hasDiscountPeriod()) ? "style='text-decoration: line-through'" : '' ?>>
                        <?php if ($model->new_price): ?>
                        <b class="visible-xs-inline">Цена:</b> <?= $model->new_price ?> р.
                        <?php else: ?>
                            не указана
                        <?php endif ?>
                    </div>
                </div>

                <div class="col-sm-2 col-xlg-2 text-right-sm">
                    <div class="element element-download">
                        <b class="visible-xs-inline">Скачать:</b>
                        <a href="<?= Url::to(['/user/template/update', 'id' => $model->id]) ?>" class="download-archive"
                           title="Редактировать шаблон"><i class="material-icons">mode_edit</i>
                        </a>
                        <a href="<?= Url::to(['/template/download', 'id' => $model->id]) ?>" class="download-archive"
                           title="Скачать архив шаблона"><i class="material-icons">archive</i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
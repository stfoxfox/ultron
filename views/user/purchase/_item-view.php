<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Download;
use app\components\ViewHelper;

/** @var $this \yii\web\View */
/** @var $model \app\models\InvoiceTemplate */

?>

<div class="lk-table-tr">
    <div class="row min">
        <div class="col-sm-6  col-xlg-5">
            <div class="row min">
                <div class="col-sm-4">
                    <div class="element element-article">
                        <b class="visible-xs-inline">№ заказа</b> <?= $model->invoice->getDisplayNumber() ?>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="element element-date">
                        <b class="visible-xs-inline">Дата:</b> <?= Yii::$app->formatter->asDate($model->invoice->created_at, 'dd.MM.yyyy') ?>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="element element-article">
                        <b class="visible-xs-inline">Артикул:</b> <?= $model->template ? '#' . $model->template->getDisplayArticle() : 'Товар удалён' ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6  col-xlg-7">
            <div class="row min">
                <div class="col-sm-6 col-xlg-8">
                    <div class="element element-title">
                        <b class="visible-xs-inline">Шаблон:</b>
                        <a href="<?= Url::to(['template/view', 'id' => $model->template_id]) ?>" class="decoration"
                           title="Перейти на страницу шаблона"><?= Html::encode($model->template->title) ?></a>
                        <br>
                        <?= ViewHelper::addList($model->invoiceTemplateOptions, $model->invoiceTemplateServices, 'title'); ?>
                    </div>
                </div>
                <div class="col-sm-3 col-xlg-2">
                    <div class="element element-price">
                        <b class="visible-xs-inline">Цена:</b> <?= $model->price ?> р.
                        <br>
                        <?= ViewHelper::addList($model->invoiceTemplateOptions, $model->invoiceTemplateServices, 'price', ' руб'); ?>
                    </div>
                </div>
                <div class="col-sm-3 col-xlg-2 text-right-sm">
                    <div class="element element-download">
                        <b class="visible-xs-inline">Скачать:</b>
                        <?php if ($model->template): ?>
                            <a href="<?= Url::to(['/template/download', 'id' => $model->template_id]) ?>"
                               class="download-archive <?= Download::getNewVersionCount(Yii::$app->user->id, $model->template_id) > 0 ? 'update' : '' ?>"
                               title="Скачать архив шаблона"><i class="material-icons">archive</i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
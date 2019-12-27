<?php

use yii\helpers\Url;
use yii\helpers\Html;
use app\components\ViewHelper;

/** @var $this \yii\web\View */
/** @var $model \app\models\Invoice */

$price = $model->price;
$income = $model->income->sum ?? 0;
$percent = 0;
if ($income > 0 && $price > 0) {
    $percent = $income / $price * 100;
}

?>

<div class="lk-table-tr" style="<?= ($model->income && $model->income->isOnHold()) ? 'background-color: #E8EEFB;' : '' ?>">
    <div class="row min">
        <div class="col-sm-6  col-xlg-5">
            <div class="row min">
                <div class="col-sm-4">
                    <div class="element element-article">
                        <b class="visible-xs-inline">№ заказа:</b> #<?= $model->invoice->getDisplayNumber() ?>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="element element-date">
                        <b class="visible-xs-inline">Дата:</b> <?= Yii::$app->formatter->asDate($model->invoice->paid_at, 'dd.MM.yyyy') ?>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="element element-article">
                        <b class="visible-xs-inline">Артикул:</b>
                        #<?= $model->template->getDisplayArticle() ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6  col-xlg-7">
            <div class="row min">
                <div class="col-sm-5 col-xlg-5">
                    <div class="element element-title">
                        <b class="visible-xs-inline">Название шаблона:</b>
                        <a href="<?= Url::to(['template/view', 'id' => $model->template_id]) ?>">
                            <?= Html::encode($model->template->title) ?>
                        </a>
                        <br>
                        <?= ViewHelper::addList($model->invoiceTemplateOptions, $model->invoiceTemplateServices, 'title') ?>
                    </div>
                </div>
                <div class="col-sm-3 col-xlg-3">
                    <div class="element element-title">
                        <b class="visible-xs-inline">Цена:</b> <?= $price ?> р.
                        <br>
                        <?= ViewHelper::addList($model->invoiceTemplateOptions, $model->invoiceTemplateServices, 'price', 'p.') ?>
                    </div>
                </div>
                <div class="col-sm-4 col-xlg-4 text-right-sm">
                    <div class="element element-price">
                        <b class="visible-xs-inline">Доход:</b> <?= $income ?> р.
                        (<?= $percent; ?>%)
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
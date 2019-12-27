<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var $this \yii\web\View */
/** @var $model \app\models\Payout */

?>

<div class="lk-table-tr">
    <div class="row min">
        <div class="col-sm-6  col-xlg-5">
            <div class="row min">
                <div class="col-sm-4">
                    <div class="element element-article">
                        <b class="visible-xs-inline">№ выплаты</b> <?= $model->getDisplayNumber() ?>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="element element-date">
                        <b class="visible-xs-inline">Дата:</b> <?= Yii::$app->formatter->asDate($model->created_at, 'dd.MM.yyyy') ?>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="element element-article">
                        <b class="visible-xs-inline">Операция:</b> Партнерское вознаграждение
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6  col-xlg-7">
            <div class="row min">
                <div class="col-sm-6 col-xlg-8">
                    <div class="element element-title">
                        <b class="visible-xs-inline">Система:</b> <?= $model->getDisplayPaymentType() ?>
                    </div>
                </div>
                <div class="col-sm-3 col-xlg-2">
                    <div class="element element-title">
                        <b class="visible-xs-inline">Статус:</b> Выплачено
                    </div>
                </div>
                <div class="col-sm-3 col-xlg-2 text-right-sm">
                    <div class="element element-price">
                        <b class="visible-xs-inline">Сумма:</b> <?= $model->sum ?> р.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php

use app\widgets\profileblock\ProfileBlock;
use app\widgets\topmenu\TopMenu;
use yii\helpers\Url;

/** @var $this \yii\web\View */
/** @var $model \app\models\search\TemplateSearch */
/** @var $dataProvider \yii\data\ActiveDataProvider */

?>
<div class="row push20">
    <div class="col-sm-8">
        <div class="title-h2">Мои выплаты</div>
    </div>
</div>

<div class="cleaner"></div>

<div class="row push20">
    <div class="col-sm-8">
        <div>Выплата осуществляется 1-3 числа каждого месяца.</div>
    </div>
</div>

<div class="purchases">
    <div class="lk-table-block">
        <div class="lk-table-block-top">
            <div class="select-box"> &nbsp;</div>
            <div class="cleaner"></div>
            <div class="push20"></div>
        </div>
        <div class="lk-table-block-middle">
            <div class="lk-table">
                <div class="lk-table-th hidden-xs">
                    <div class="row min">
                        <div class="col-sm-6  col-xlg-5">
                            <div class="row min">
                                <div class="col-sm-4">
                                    № выплаты
                                </div>
                                <div class="col-sm-4">
                                    Дата
                                </div>
                                <div class="col-sm-4">
                                    Операция
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6  col-xlg-7">
                            <div class="row min">
                                <div class="col-sm-6 col-xlg-8">
                                    Система
                                </div>
                                <div class="col-sm-3 col-xlg-2">
                                    Статус
                                </div>
                                <div class="col-sm-3 col-xlg-2 text-right">
                                    Сумма
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?= \yii\widgets\ListView::widget([
                    'dataProvider' => $dataProvider,
                    'itemView' => '_item-view',
                    'summary' => '',
                ]) ?>

            </div>
        </div>
    </div>
</div>
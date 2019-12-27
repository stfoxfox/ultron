<?php

use app\widgets\profileblock\ProfileBlock;
use app\widgets\topmenu\TopMenu;
use yii\helpers\Url;

/** @var $this \yii\web\View */
/** @var $model \app\models\search\TemplateSearch */
/** @var $dataProvider \yii\data\ActiveDataProvider */

?>

<div class="title-h2">Мои продажи</div>

<div style="clear: both;"></div>

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
                        <div class="col-sm-6  col-xlg-6">
                            <div class="row min">
                                <div class="col-sm-4">
                                    № заказа
                                </div>
                                <div class="col-sm-4">
                                    Дата
                                </div>
                                <div class="col-sm-4">
                                    Артукул
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6  col-xlg-6">
                            <div class="row min">
                                <div class="col-sm-5 col-xlg-5">
                                    Название шаблона
                                </div>
                                <div class="col-sm-3 col-xlg-3">
                                    Цена
                                </div>
                                <div class="col-sm-4 col-xlg-4 text-right">
                                    Доход
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
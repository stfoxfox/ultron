<?php

use app\widgets\profileblock\ProfileBlock;
use app\widgets\topmenu\TopMenu;

/** @var $this \yii\web\View */
/** @var $model \app\models\search\TemplateSearch */
/** @var $dataProvider \yii\data\ActiveDataProvider */

?>

<div class="title-h2">Мои шаблоны</div>
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
                        <div class="col-sm-3  col-xlg-3">
                            <div class="row min">
                                <div class="col-sm-5">
                                    Артикул
                                </div>
                                <div class="col-sm-7">
                                    Дата
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-9 col-xlg-9">
                            <div class="row min">
                                <div class="col-sm-6 col-xlg-6">
                                    Шаблон
                                </div>
                                <div class="col-sm-2 col-xlg-2">
                                    Цена
                                </div>
                                <div class="col-sm-2 col-xlg-2">
                                    Новая цена
                                </div>
                                <div class="col-sm-2 col-xlg-2 text-right">
                                    Скачать
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
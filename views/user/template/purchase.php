<?php

use app\widgets\profileblock\ProfileBlock;
use app\widgets\topmenu\TopMenu;

/** @var $this \yii\web\View */
/** @var $model \app\models\User */

?>

<div class="title-h2">Мои шаблоны</div>
<div class="purchases">
    <div class="lk-table-block">
        <div class="lk-table-block-top">
            <div class="select-box">
                <select class="select-styler">
                    <option>Период</option>
                    <option>Сегодня</option>
                    <option>Вчера</option>
                    <option>Текущая неделя</option>
                    <option>Прошлая неделя</option>
                    <option>Текущий месяц</option>
                    <option>Прошлый месяц</option>
                </select>
            </div>
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
                                    № заказа
                                </div>
                                <div class="col-sm-4">
                                    Дата
                                </div>
                                <div class="col-sm-4">
                                    Артикул
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6  col-xlg-7">
                            <div class="row min">
                                <div class="col-sm-6 col-xlg-8">
                                    Шаблон
                                </div>
                                <div class="col-sm-3 col-xlg-2">
                                    Цена
                                </div>
                                <div class="col-sm-3 col-xlg-2 text-right">
                                    Скачать
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lk-table-tr">
                    <div class="row min">
                        <div class="col-sm-6  col-xlg-5">
                            <div class="row min">
                                <div class="col-sm-4">
                                    <div class="element element-id">
                                        <b class="visible-xs-inline">Номер заказа:</b> 01312323
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="element element-date">
                                        <b class="visible-xs-inline">Дата:</b> 12.11.2016
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="element element-article">
                                        <b class="visible-xs-inline">Артикул:</b> #0543442
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6  col-xlg-7">
                            <div class="row min">
                                <div class="col-sm-6 col-xlg-8">
                                    <div class="element element-title">
                                        <b class="visible-xs-inline">Шаблон:</b>
                                        <a href="#" class="decoration"
                                           title="Перейти на страницу шаблона">Лендинг
                                            автосервиса</a>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-xlg-2">
                                    <div class="element element-price">
                                        <b class="visible-xs-inline">Цена:</b> 1700 руб.
                                    </div>
                                </div>
                                <div class="col-sm-3 col-xlg-2 text-right-sm">
                                    <div class="element element-download">
                                        <b class="visible-xs-inline">Скачать:</b>
                                        <a href="#" class="download-archive"
                                           title="Скачать архив шаблона"><i
                                                    class="material-icons">archive</i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="lk-table-tr">
                    <div class="row min">
                        <div class="col-sm-6  col-xlg-5">
                            <div class="row min">
                                <div class="col-sm-4">
                                    <div class="element element-id">
                                        <b class="visible-xs-inline">Номер заказа:</b> 01312467
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="element element-date">
                                        <b class="visible-xs-inline">Дата:</b> 12.12.2016
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="element element-article">
                                        <b class="visible-xs-inline">Артикул:</b> #0443432
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6  col-xlg-7">
                            <div class="row min">
                                <div class="col-sm-6 col-xlg-8">
                                    <div class="element element-title">
                                        <b class="visible-xs-inline">Шаблон:</b>
                                        <a href="#" class="decoration"
                                           title="Перейти на страницу шаблона">Лендинг по
                                            продаже цветов</a>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-xlg-2">
                                    <div class="element element-price">
                                        <b class="visible-xs-inline">Цена:</b> 1500 руб.
                                    </div>
                                </div>
                                <div class="col-sm-3 col-xlg-2 text-right-sm">
                                    <div class="element element-download">
                                        <b class="visible-xs-inline">Скачать:</b>
                                        <a href="#" class="download-archive update"
                                           title="Скачать обновление - версия 1.5"><i
                                                    class="material-icons">archive</i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
<?php

use app\widgets\topmenu\TopMenu;
use yii\helpers\Url;
use app\components\File;
use app\models\Template;
use yii\helpers\Html;
use app\models\Favorite;

/* @var $this yii\web\View */

//$this->title = 'My Yii Application';

?>

<?= TopMenu::widget() ?>

<div class="push50"></div>

<div class="index-novelty">
    <div class="container">
        <div class="text-left">
            <div class="title-h1">Избранное</div>
            <?php if (count($models) == 0): ?>
                <div class="subtitle gray">
                    Вы пока ещё не добавили сюда ни одного шаблона.
                </div>
            <?php endif; ?>
        </div>
        <div class="push15"></div>
        <div class="products">
            <div class="row">

                <?php foreach ($models as $model): ?>
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <div class="element relative">
                            <a href="<?= Url::to(['template/view', 'id' => $model->template->id]) ?>"
                               class="absolute"></a>

                            <?php if (!Yii::$app->user->isGuest): ?>
                                <div class="msfavorites">
                                    <?php if (Favorite::isExists(Yii::$app->user->id, $model->template)): ?>
                                        <a href="<?= Url::to(['favorite/toggle', 'id' => $model->template->id]) ?>"
                                           class="msfavorites-remove msfavorites-link"><i
                                                    class="material-icons active-icon">favorite</i></a>
                                    <?php else: ?>
                                        <a href="<?= Url::to(['favorite/toggle', 'id' => $model->template->id]) ?>"
                                           class="msfavorites-add msfavorites-link"><i class="material-icons">favorite_border</i></a>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <div class="element-visible-block">
                                <div class="img-wrapper relative">
                                    <img src="<?= File::src($model->template->firstPicture, 'file_name', [370, 350]) ?>"/>
                                    <?php if ($model->template->displayCssLabel): ?>
                                        <div class="sticker <?= $model->template->displayCssLabel ?>"><i
                                                    class="material-icons">lightbulb_outline</i>
                                            <?= Template::getLabelText($model->template->displayCssLabel) ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($model->template->isDiscountPeriod()): ?>
                                        <div class="action-timer">
                                            <div class="countdown" data-actionyear="<?= date('Y', strtotime($model->template->discount_date)) ?>"
                                                 data-actionmonth="<?= date('m', strtotime($model->template->discount_date)) ?>"
                                                 data-actionday="<?= date('d', strtotime($model->template->discount_date)) ?>">
                                                <div class="countdown-text text-center">
                                                    <div class="row no-padding">
                                                        <div class="col-xs-3">
                                                            <span>дни</span>
                                                        </div>
                                                        <div class="col-xs-3">
                                                            <span>часы</span>
                                                        </div>
                                                        <div class="col-xs-3">
                                                            <span>минуты</span>
                                                        </div>
                                                        <div class="col-xs-3">
                                                            <span>секунды</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="element-content">
                                    <div class="element-content-header relative">
                                        <div class="type-icon">
                                            <img src="<?= File::src($model->template->type, 'picture', [32, 32]) ?>"
                                                 onerror="this.onerror=null; this.src='<?= File::src($model->template->type, 'picture', [32, 32]) ?>'"
                                                 width="32">
                                        </div>
                                        <div class="title">
                                            <div class="table">
                                                <div class="table-cell">
                                                    <span><?= Html::encode($model->template->title) ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="push5"></div>
                                        <div class="product-info">
                                            <span class="subtitle"><?= $model->template->type->short_title ?></span>
                                            <span
                                                    class="article">#<?= $model->template->getDisplayArticle() ?></span>
                                            <div class="cleaner"></div>
                                        </div>
                                    </div>
                                    <div class="element-content-footer relative">
                                        <?php if ($model->template->new_price): ?>
                                            <span class="price"><?= $model->template->new_price ?> р.</span>
                                            <span class="old-price strike"><?= $model->template->price ?> р.</span>
                                        <?php else: ?>
                                            <span class="price"><?= $model->template->price ?> р.</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="element-hidden-block hidden-xs hidden-sm">
                                <a href="<?= Url::to(['template/view', 'id' => $model->template->id]) ?>"
                                   class="absolute"></a>
                                <div class="row min">
                                    <?php if ($model->template->demo_url): ?>
                                        <div class="col-xs-5">
                                            <a href="<?= $model->template->demo_url ?>" target="_blank"
                                               class="btn btn-navy block first">Демо <i
                                                        class="material-icons">remove_red_eye</i></a>
                                        </div>
                                    <?php endif; ?>
                                    <div class="<?= $model->template->demo_url ? 'col-xs-7' : '' ?>">
                                        <a href="<?= Url::to(['template/view', 'id' => $model->template->id]) ?>"
                                           class="btn block last">Подробнее <i
                                                    class="material-icons">arrow_forward</i></a>
                                    </div>
                                </div>
                                <div class="element-tags relative">
                                    <?php foreach ($model->template->tags as $tag): ?>
                                        <a href="<?= Url::to(['template/index', 'tag' => $tag->alias]) ?>">
                                            #<?= Html::encode($tag->title) ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
            <div class="push20"></div>
            <div class="push40 hidden-xs hidden-sm"></div>
            <div class="push30 visible-xs visible-sm"></div>
        </div>
    </div>
</div>
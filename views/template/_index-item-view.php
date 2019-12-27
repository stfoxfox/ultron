<?php

use yii\helpers\Url;
use yii\helpers\Html;
use app\models\Favorite;
use app\components\File;
use app\models\Template;

/** @var $model \app\models\Template */

?>

<div class="col-sm-6 col-lg-4" data-order="<?= $model->id ?>">
    <div class="element relative">
        <a href="<?= Url::to(['template/view', 'id' => $model->alias]) ?>" class="absolute"></a>

        <?php if (!Yii::$app->user->isGuest): ?>
            <noindex>
			<div class="msfavorites">
                <?php if (Favorite::isExists(Yii::$app->user->id, $model)): ?>
                    <a href="<?= Url::to(['favorite/toggle', 'id' => $model->id]) ?>"
                       class="msfavorites-remove msfavorites-link"><i
                                class="material-icons active-icon">favorite</i></a>
                <?php else: ?>
                    <a href="<?= Url::to(['favorite/toggle', 'id' => $model->id]) ?>"
                       class="msfavorites-add msfavorites-link"><i class="material-icons">favorite_border</i></a>
                <?php endif; ?>
            </div>
			</noindex>
        <?php endif; ?>

        <div class="element-visible-block">
            <div class="img-wrapper relative">
                <img data-src="<?= File::src($model->firstPicture, 'file_name', [370, 350]) ?>">
                <?php if ($model->displayCssLabel): ?>
                    <div class="sticker <?= $model->displayCssLabel ?>">
                        <i class="material-icons">lightbulb_outline</i>
                        <?= Template::getLabelText($model->displayCssLabel) ?>
                    </div>
                <?php endif; ?>
                <?php if ($model->isDiscountPeriod()): ?>
                    <div class="action-timer">
                        <noindex>
						<div class="countdown" data-actionyear="<?= date('Y', strtotime($model->discount_date)) ?>"
                             data-actionmonth="<?= date('m', strtotime($model->discount_date)) ?>"
                             data-actionday="<?= date('d', strtotime($model->discount_date)) ?>">
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
						</noindex>
                    </div>
                <?php endif; ?>
            </div>
            <div class="element-content">
                <div class="element-content-header relative">
                    <div class="type-icon">
                        <img data-src="<?= File::src($model->type, 'picture', [32, 32]) ?>"
                             onerror="this.onerror=null; this.src='<?= File::src($model->type, 'picture', [32, 32]) ?>'"
                             width="32">
                    </div>
                    <div class="title">
                        <div class="table">
                            <div class="table-cell">
                                <span><?= Html::encode($model->title) ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="push5"></div>
                    <noindex>
					<div class="product-info">
                        <span class="subtitle"><?= $model->type->short_title ?></span> <span
                                class="article">#<?= $model->getDisplayArticle() ?></span>
                        <div class="cleaner"></div>
                    </div>
					</noindex>
                </div>
                <noindex>
				<div class="element-content-footer relative">
                    <?php if ($model->actualPrice != $model->price): ?>
                        <span class="price"><?= $model->actualPrice ?> р.</span>
                        <span class="old-price strike"><?= $model->price ?> р.</span>
                    <?php elseif ($model->is_free): ?>
                        <span class="price">Бесплатно</span>
                    <?php else: ?>
                        <span class="price"><?= $model->price ?> р.</span>
                    <?php endif; ?>
                </div>
				</noindex>
            </div>
        </div>
        <div class="element-hidden-block hidden-xs hidden-sm">

            <a href="<?= Url::to(['template/view', 'id' => $model->id]) ?>" class="absolute"></a>
            <div class="element-author relative">
                <span class="bold">Автор:</span>
                <a href="<?= Url::to(['template/index', 'author' => $model->user->username]) ?>"><?= Html::encode($model->user->username) ?></a>
            </div>
            <noindex>
			<div class="row min">
                <?php if ($model->demo_url): ?>
                    <div class="col-xs-5">
                        <a href="<?= $model->demo_url ?>" target="_blank" class="btn btn-navy block first" rel="nofollow">
                            Демо <i class="material-icons">remove_red_eye</i>
                        </a>
                    </div>
                <?php endif; ?>
                <div class="<?= $model->demo_url ? 'col-xs-7' : '' ?>">
                    <a href="<?= Url::to(['template/view', 'id' => $model->id]) ?>" class="btn block last" rel="nofollow">
                        Подробнее
                        <i class="material-icons">arrow_forward</i>
                    </a>
                </div>
            </div>

            <div class="element-tags relative">
                <?php foreach ($model->tags as $tag): ?>
                    <a href="<?= Url::to(['template/index', 'tag' => $tag->alias]) ?>">
                        #<?= Html::encode($tag->title) ?>
                    </a>
                <?php endforeach; ?>
            </div>
			</noindex>
        </div>
    </div>
</div>
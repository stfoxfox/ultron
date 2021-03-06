<?php

use app\widgets\topmenu\TopMenu;
use yii\helpers\Url;
use yii\helpers\Html;
use app\models\Template;
use app\models\Favorite;
use app\components\File;
use app\widgets\cart\Cart;
use app\widgets\categories\Categories;

/** @var $this \yii\web\View */
/** @var $model \app\models\Template */

?>


<?= TopMenu::widget() ?>

<div class="middle">
    <div class="push15"></div>
    <noindex>
	<div class="breadcrumbs-wrapper">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="<?= Url::home() ?>">Главная</a></li>
                <i class="material-icons">navigate_next</i>
                <li>
                    <?= Html::a(Html::encode($model->type->title), ['/template/index', 'type' => $model->type->alias]) ?>
                </li>
                <i class="material-icons">navigate_next</i>
                <li>
                    <?= Html::encode($model->title)?>
                </li>
            </ul>
        </div>
    </div>
	</noindex>
    <div class="push20"></div>

    <div class="product-container" itemscope itemtype="http://schema.org/Product">
        <div class="container">
    
			<div itemprop="name"><h1><?= Html::encode($model->title) ?></h1></div>
            <hr/>
            <div class="push15"></div>

            <?php if (!$model->getIsAllowedToView()): ?>
                <div class="alert alert-danger">
                    Данный шаблон временно не доступен.
                </div>
            <?php else: ?>
                <div class="row">
                    <div class="col-xlg-9 col-xlg-push-3">
                        <div class="product-top-info-block relative f13">
                            <div class="product-rating">
                                <div class="ec-stars" title="5">
                                    <?php for ($i = 1; $i < 6; $i++): ?>
                                        <noindex><i class="material-icons" title="<?=$i?>">star_border</i></noindex>
                                    <?php endfor ?>
                                    <span style="width: <?= $model->getRatingPercentage() ?>%">
                                        <? for ($i = 1; $i < 6; $i++): ?>
                                            <noindex><i class="material-icons">star</i></noindex>
                                        <? endfor ?>
                                    </span>
                                </div>
                            </div>

                            <noindex>
							<span class="element">
                                    <span class="bold">Тип:</span> <span
                                        class="navy"><?= Html::encode($model->type->short_title) ?></span>
                                </span>
                            <span class="element">
                                    <span class="bold">№:</span> <span
                                        class="navy">#<?= $model->getDisplayArticle() ?></span>
                                </span>
                            <span class="element">
                                    <span class="bold">Продан раз:</span> <span class="navy">
                                <?= $model->getSalesCount() ?>
                            </span>
                                </span>
                            <span class="element">
                                    <span class="bold">Автор:</span> <a
                                        href="<?= Url::to(['template/index', 'author' => $model->user->username]) ?>"><?= Html::encode($model->user->username) ?></a>
                                </span>
                            <!--<span class="element"><span class="bold">Рекомендуемый хостинг: </span><a
                                        href="#">Timeweb</a></span>-->
                            <div class="cleaner"></div>
							</noindex>
                        </div>
                        <div class="push10"></div>
                        <div class="row">
                            <div class="col-md-8 custom">
                                <div class="main-column">
                                    <div class="product-img relative lightgallery"
                                         style="background: url(<?= File::src($model->firstPicture, 'file_name', [960, 900]) ?>) 50% 0 no-repeat; background-size: cover;">

                                        <?php if ($model->getDisplayCssLabel()): ?>
                                            <noindex>
											<div class="sticker <?= $model->getDisplayCssLabel() ?>"><i
                                                        class="material-icons">star_rate</i> <?= Template::getLabelText($model->getDisplayCssLabel()) ?>
                                            </div>
											</noindex>
                                        <?php endif; ?>

                                        <?php if (!Yii::$app->user->isGuest): ?>
                                            <noindex>
											<div class="msfavorites">
                                                <?php if (Favorite::isExists(Yii::$app->user->id, $model)): ?>
                                                    <a href="<?= Url::to(['favorite/toggle', 'id' => $model->id]) ?>"
                                                       class="msfavorites-remove msfavorites-link"><i
                                                                class="material-icons active-icon">favorite</i></a>
                                                <?php else: ?>
                                                    <a href="<?= Url::to(['favorite/toggle', 'id' => $model->id]) ?>"
                                                       class="msfavorites-add msfavorites-link"><i
                                                                class="material-icons">favorite_border</i></a>
                                                <?php endif; ?>
                                            </div>
											</noindex>
                                        <?php endif; ?>

                                        <?php foreach ($model->pictures as $picture): ?>
                                            <a href="<?= File::src($picture, 'file_name', [1200, null]) ?>" itemprop="image"
                                               class="absolute lightgallery-link">

                                                <noindex>
												<div class="table">
                                                    <div class="table-cell text-center">
                                                        <i class="material-icons white">zoom_in</i>
                                                    </div>
                                                </div>
												</noindex>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                    <?php if ($model->isDiscountPeriod()): ?>
                                        <?= $this->render('_view-discount-counter', compact('model')) ?>
                                    <?php endif; ?>
                                    <div class="push15"></div>
                                    <div class="share">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="push2 hidden-xs"></div>
                                                <div class="title bold black f18">
                                                <!--    <a href="#">Поделись и заработай!</a>
                                                    <i class="material-icons help-icon">help</i>
                                                    <div class="hide">
                                                        <?= \app\models\Snippet::findByKey('social-share-hint')->value ?>
                                                    </div>
                                                    -->
                                                </div>
                                                <div class="push10 visible-xs"></div>
                                            </div>
                                            <div class="col-sm-6 share-links text-right-sm">
                                                <a href="https://vk.com/share.php?url=<?=Yii::$app->request->absoluteUrl?>" class="vk" target="_blank" rel="nofollow" >
                                                    <i class='fa fa-vk' aria-hidden='true'></i>
                                                </a>
                                                <a href="https://connect.ok.ru/offer?url=<?=Yii::$app->request->absoluteUrl?>" class="ok" target="_blank" rel="nofollow" >
                                                    <i class="fa fa-odnoklassniki" aria-hidden="true"></i>
                                                </a>
                                                <a href="https://www.facebook.com/sharer.php?u=<?=Yii::$app->request->absoluteUrl?>" class="fb" target="_blank" rel="nofollow" >
                                                    <i class="fa fa-facebook" aria-hidden="true"></i>
                                                </a>
<!--                                                <a href="#" class="inst" target="_blank">-->
<!--                                                    <i class="fa fa-instagram" aria-hidden="true"></i>-->
<!--                                                </a>-->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="push30"></div>
                                </div>
                            </div>
                            <?= Cart::widget(['template' => $model]) ?>
                        </div>
                        <?= $this->render('_view-tabs', compact('model')) ?>
                    </div>

                    <noindex>
					<div class="col-xlg-3 col-xlg-pull-9 visible-xlg">
                        <?= Categories::widget([
                            'template' => $model,
                        ]) ?>
                    </div>
					</noindex>

                </div>
            <?php endif; ?>

        </div>
    </div>

    <div class="push50"></div>
</div>

<?php

$shareScript = "
$.fn.customerPopup = function (e, intWidth, intHeight, blnResize) {
    e.preventDefault();
    intWidth = intWidth || '600';
    intHeight = intHeight || '350';
    strResize = (blnResize ? 'yes' : 'no');
    var left = window.innerWidth / 2 - 300,
        top = window.innerHeight / 2 - 175;
    var strTitle = ((typeof this.attr('title') !== 'undefined') ? this.attr('title') : 'Social Share'),
        strParam = 'width=' + intWidth + ',height=' + intHeight + ',resizable=' + strResize + ',left=' + left + ',top=' + top,
        objWindow = window.open(this.attr('href'), strTitle, strParam).focus();
}

$(document).ready(function () {
    $('.share-links a').click(function (e) {
        $(this).customerPopup(e);
    });

//    $('.fb').click(function () {
//        FB.ui({method: 'share', href: '" . Yii::$app->request->absoluteUrl . "',}, function (response) {
//        });
//    });
});
//";
//$this->registerJsFile("//connect.facebook.net/en_US/sdk.js");
$this->registerJs($shareScript, \yii\web\View::POS_END);
<?php

use yii\helpers\Url;
use app\components\File;
?>

<div class="index-subscribe-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-lg-5">
                <div class="index-promo-carousel-wrapper">
                    <div class="index-promo-carousel">
                        <?php foreach ($banners as $banner):  ?> 
                            <div class="item">
                                <div class="element relative">
                                    <a href="<?=$banner->url?>" class="absolute"></a>
                                    <img data-src="<?= File::src($banner, 'picture', [630, 300]) ?>"/>
                                </div>
                            </div>
                        <?php endforeach;?>
                    </div>
                </div>
                <div class="push20"></div>
            </div>
            <div class="col-md-6 col-lg-7">
                <div class="subscribe-block">
                    <div class="title relative">
                        <img data-src="<?= Url::base() ?>/images/no-spam.png"/>
                        Подпишитесь <br/>
                        на рассылку
                    </div>
                    <div class="text">Новинки, акции и скидки на вашей почте!</div>
                    <form class="rf">
                        <div class="inner relative">
                            <input type="email" class="required" placeholder="Email" id="subscribe-email-field"/>
                            <input type="submit" class="btn" value="Подписаться" id="subscribe-email-button"
                                   data-url="<?= Url::to(['site/subscribe']) ?>"/>
                        </div>
                    </form>
                </div>
                <div class="push20"></div>
            </div>
        </div>
    </div>
    <div class="push10"></div>
</div>
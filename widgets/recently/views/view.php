<?php

use yii\widgets\ListView;
use yii\helpers\Url;
use app\widgets\favorite\FavoriteSlider;

/** @var $dataProvider \yii\data\ActiveDataProvider */

?>

<div class="index-novelty">
    <div class="container">
        <div class="text-center">
            <div class="title-h1"><h1>Адаптивные шаблоны сайтов HTML, готовые сайты на MODX и WordPress</h1></div>
		</div>
            <div class="subtitle gray">
                Купить и скачать шаблоны сайтов на русском языке теперь легко! Мы предлагаем авторские работы и только профессиональных веб-разработчиков.
				<br>
				Мы не предлагаем бесплатные шаблоны или избитые темы, мы интересны и полезны веб-разработчикам, которые хотят сделать сайт сами, используя наши уникальные и профессиональные решения. 
				<br>
				MODX шаблоны (MODX-сборки) - это готовые сайты, которые на 90% удовлетворяют покупателя в своем коробочном варианте. Устанавливаете MODX сборку на хостинг и получаете готовый к работе сайт по цене в десятки раз меньше чем такой же, заказанный в студии!
				В отличии от конструктора сайта, вы получаете собственный, готовый к работе сайт без какой-либо абонентской платы, который можно обновлять и совершенствовать собственными силами или силами сторонних специалистов.
				<br>
				Адаптивные HTML шаблоны, платные и бесплатные, готовы для интеграции с любимой вашей CMS. Создать сайт самостоятельно - с нашими решениями проще!
            </div>
            <hr/>
        <!--
		</div>
		-->
        <div class="push15"></div>
        <div class="products">
            <div class="row">
                <?= ListView::widget([
                    'dataProvider' => $lastTemplateDataProvider,
                    'itemView' => '_item-view',
                    'summary' => '',
                ]) ?>
            </div>
            <div class="push20"></div>
            <div class="text-center">
                <a href="<?= Url::to(['template/index']) ?>" class="btn all-btn block">
                    <noindex><i class="material-icons">star_border</i> Смотреть все шаблоны</a></noindex>
            </div>
            <div class="push20"></div>
            <div class="row carousel-row">
                <?php if($dataProvider->getTotalCount() > 0):?>
                    <?= FavoriteSlider::widget(['templates' => $dataProvider->getModels()])?>
                <?php endif ?>
            </div>
            
            <div class="push40 hidden-xs hidden-sm"></div>
            <div class="push30 visible-xs visible-sm"></div>
        </div>
    </div>
</div>
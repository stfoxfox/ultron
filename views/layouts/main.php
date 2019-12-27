<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use app\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);

$types = \app\models\Type::find()
    ->orderBy(['ordering' => SORT_ASC])
    ->all();

?><?php $this->beginPage() ?><!DOCTYPE html>
<html>
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <title><?= Html::encode($this->title) ?></title>
        <?= Html::csrfMetaTags() ?>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="theme-color" content="#141D23"/>
		<meta name="yandex-verification" content="c61e27ba22d09748" />
		<meta name="google-site-verification" content="yfOVoh02AZWLuk9on4KPkET2MK83XN1gtchWWEo-Mvw" />
        <link rel="icon" type="image/png" href="/favicon.png" />
        <link rel="apple-touch-icon-precomposed" href="apple-touch-favicon.png"/>

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-80294418-8"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
        
          gtag('config', 'UA-80294418-8');
        </script>
        <?php $this->head() ?>
		
		<script charset="UTF-8" src="//cdn.sendpulse.com/js/push/bd2b50c9f92f0761080e64cdde0209cc_1.js" async></script>
		<script async src="https://stats.lptracker.ru/code/new/68523"></script>
    </head>
    <body class="index-template">
    <?php $this->beginBody() ?>
    <!-- Mobile menu -->
    <div class="mobile-menu" id="mobmenu">
        <div class="menu-button">
            <span class="icon-menu-burger">
                <span class="icon-menu-burger__line"></span>
            </span>
        </div>

        <a href="<?= Url::home() ?>" class="mob-menu-logo">
            <img data-src="<?= Url::base() ?>/images/logo-mobile-menu.svg" alt="logo" width="200" onerror="this.onerror=null; this.src='<?= Url::base() ?>/images/logo-mobile-menu.png'"/>
        </a>

        <div class="push15"></div>
        <ul>
            <li><a href="<?= Url::to(['template/index']) ?>">Все шаблоны</a></li>
            <?php foreach ($types as $type): ?>
                <li>
                    <a href="<?= Url::to(['template/index', 'type' => $type->alias]) ?>">
                        <?= $type->short_title ?>
                    </a>
                </li>
            <?php endforeach; ?>

            <!--
			<li><a href="<?= Url::to(['page/view', 'alias' => 'about']) ?>">О нас</a></li>
            <li><a href="#">Блог</a></li>
            -->
			<li><a href="<?= Url::to(['news/index']) ?>">Новости</a></li>
			<li><a href="<?= Url::to(['page/view', 'alias' => 'contacts']) ?>">Контакты</a></li>
            <!--<li><a href="<?= Url::to(['page/view', 'alias' => 'rules']) ?>">Правила сервиса</a></li>-->
            <li><a href="<?= Url::to(['page/view', 'alias' => 'agreement']) ?>">Соглашение</a></li>
            <!--<li><a href="<?= Url::to(['page/view', 'alias' => 'support']) ?>">Техническая поддержка</a></li>-->
            <li><a href="<?= Url::to(['page/view', 'alias' => 'conditions']) ?>">Правила возврата</a></li>
            <!--<li><a href="<?= Url::to(['page/view', 'alias' => 'hosting']) ?>">Рекомендуемый хостинг</a></li>-->
            <li><a href="/seller">Веб-мастеру</a></li>
            <!--
            <li><a href="<?= Url::to(['page/view', 'alias' => 'partners']) ?>">Партнерство</a></li>
            <li><a href="<?= Url::to(['page/view', 'alias' => 'for-authors']) ?>">Правила для авторов</a></li>
            -->
        </ul>

        <div class="push20"></div>
        <div class="mobile-menu-social social-links">

        </div>
        <div class="push30"></div>
    </div>
    <div class="overlay"></div>
    <!-- Mobile menu end -->

    <div class="main-wrapper">

        <?= $this->render('_header') ?>
        <?= $content; ?>

        <div class="footer-push"></div>
    </div>
    <div class="footer-wrapper">
        <div class="push30 hidden-xs"></div>
        <div class="container relative">
            <div class="footer-social">
                <a href="https://vk.com/ultron_pro" class="vk" target="_blank"><i class="fa fa-vk"></i></a> 
                <a href="https://www.instagram.com/ultron.pro/" class="inst" target="_blank"><i class="fa fa-instagram"></i></a>
                <a href="https://ok.ru/group/54740235780209?st._aid=ExternalGroupWidget_OpenGroup" class="ok" target="_blank"><i class="fa fa-odnoklassniki"></i></a>
                <a href="https://www.facebook.com/www.ultron.pro/" class="fb" target="_blank"><i class="fa fa-facebook"></i></a>
            </div>
            <div class="footer-top hidden-xs">
                <div class="footer-menu">
                    <div class="row">
                        <div class="col-sm-6 col-md-3">
                            <div class="title">Категории</div>
                            <ul>
                                <?php foreach (\app\models\Type::find()->all() as $type): ?>
                                    <li>
                                        <a href="<?= Url::to(['template/index', 'type' => $type->alias]) ?>">
                                            <?= $type->short_title ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <hr class="cleaner-hr"/>
                        <div class="col-sm-6 col-md-3">
                            <div class="title">Компания</div>
                            <ul>
                                <li><a href="<?= Url::to(['page/view', 'alias' => 'about']) ?>">О нас</a></li>
                                <li><a href="<?= Url::to(['news/index']) ?>">Новости</a></li>
                                <li><a href="<?= Url::to(['page/view', 'alias' => 'contacts']) ?>">Контакты</a></li>
                            </ul>
                        </div>
                        <hr class="cleaner-hr"/>
                        <div class="col-sm-6 col-md-3">
                            <div class="title">Информация</div>
                            <ul>
                                <!--<li><a href="<?= Url::to(['page/view', 'alias' => 'rules']) ?>">Правила сервиса</a></li>-->
                                <li><a href="<?= Url::to(['page/view', 'alias' => 'agreement']) ?>">Соглашение</a></li>
                                <li><a href="<?= Url::to(['page/view', 'alias' => 'online-pay']) ?>">Online Оплата</a></li>
                                <li><a href="<?= Url::to(['page/view', 'alias' => 'conditions']) ?>">Правила возврата</a></li>
								<li><a href="<?= Url::to(['page/view', 'alias' => 'support']) ?>">Помощь покупателю</a></li>
								<!--
								<li><a href="<?= Url::to(['user/help']) ?>">Помощь</a></li>
                                <li><a href="<?= Url::to(['page/view', 'alias' => 'hosting']) ?>">Рекомендуемый хостинг</a></li>-->
                            </ul>
                        </div>
                        <hr class="cleaner-hr"/>
                        <div class="col-sm-6 col-md-3">
                            <div class="title">Сотрудничество</div>
                            <ul>
                                <li><a href="<?= Url::to(['/site/seller']) ?>">Веб-мастеру</a></li>
                                
<li><a href="<?= Url::to(['page/view', 'alias' => 'partners']) ?>">Партнерство</a></li>
<!--
<li><a href="<?= Url::to(['page/view', 'alias' => 'for-authors']) ?>">Правила для авторов</a></li>
-->
                            </ul>
                        </div>
                        <hr class="cleaner-hr"/>
                    </div>
                </div>
            </div>
            <div class="push9 hidden-xs"></div>
            <div class="footer-bottom f12">
                <div class="push23 hidden-xs"></div>
                <div class="push20 visible-xs"></div>
                <div class="row no-padding">
                    <div class="col-sm-6">
                        <div class="push7"></div>
                        <div class="copyright">© Copyright 2016-<?= date('Y') ?>. Все права защищены.
                            <br>
                            <a href="<?= Url::to(['page/view', 'alias' => 'policy']) ?>">Политика конфиденциальности</a> сайта Ultron.pro
                        </div>
                        <div class="push15 visible-xs"></div>
                    </div>
                    <div class="col-sm-6 text-right-sm">
                        <div class="payments">
                            <div class="push15"></div>
                            Безопасные платежи: <div class="push5 visible-xs"></div>
                            <a href="https://info.paymaster.ru" rel="nofollow" target="_blank"><img data-src="<?= Url::base() ?>/images/safePayments_200x50_2.png"/ width="120"></a>
                            <div class="push15"></div>
                        </div>
                    </div>
                </div>
                <div class="push20"></div>
                <div class="push50 visible-xs"></div>
            </div>
        </div>
    </div>
    <span id="up"><i class="fa fa-angle-up"></i></span>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <?php $this->endBody(); ?>


<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

   ym(40430900, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true,
        trackHash:true,
        ecommerce:"dataLayer"
   });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/40430900" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

<!-- BEGIN JIVOSITE CODE {literal} -->
<script type='text/javascript'>
(function(){ var widget_id = '4nl8QnYvAj';var d=document;var w=window;function l(){
  var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true;
  s.src = '//code.jivosite.com/script/widget/'+widget_id
    ; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);}
  if(d.readyState=='complete'){l();}else{if(w.attachEvent){w.attachEvent('onload',l);}
  else{w.addEventListener('load',l,false);}}})();
</script>
<!-- {/literal} END JIVOSITE CODE -->

</body>
</html><?php $this->endPage(); ?>
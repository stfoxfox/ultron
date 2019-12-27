<?php

use yii\helpers\Url;
use app\models\User;
use app\models\LoginForm;
use yii\widgets\ActiveForm;
use himiklab\yii2\recaptcha\ReCaptcha3;

$register = new User(['scenario' => User::SCENARIO_REGISTER_USER]);
$login = new LoginForm();

$hasFavorites = false;
if (!Yii::$app->user->isGuest && Yii::$app->user->identity->getFavorites()->count() > 0) {
    $hasFavorites = true;
}

?>

    <noindex>
	<div class="header-wrapper">
        <div class="container">
            <div class="header relative">
                <a href="<?= Url::home() ?>" class="logo hidden-xs">
                    <img src="<?= Url::base() ?>/images/logo.svg" alt="ultron.pro"
                         onerror="this.onerror=null; this.src='<?= Url::base() ?>/images/logo.png'"/>
                </a>
                <a href="<?= Url::home() ?>" class="logo visible-xs">
                    <img src="<?= Url::base() ?>/images/logo-xs.svg"
                         alt="ultron.pro"
                         onerror="this.onerror=null; this.src='<?= Url::base() ?>/images/logo-xs.png'"/>
                </a>
                <div class="header-bar">
                    <div class="row no-padding">
                        <div class="col-xs-3 hidden-xs hidden-lg hidden-xlg">
                            <div class="element search-btn">
                                <div class="table">
                                    <div class="table-cell text-center">
                                        <i class="material-icons">search</i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if (!Yii::$app->user->isGuest): ?>
                            <div class="col-xs-3 col-lg-4">
                                <div class="element header-liked">
                                    <a href="<?= Url::to(['favorite/index']) ?>" class="absolute">
                                        <div class="table">
                                            <div class="table-cell text-center">
                                                <i class="material-icons <?= $hasFavorites ? 'active' : '' ?>">favorite</i>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        <?php else: ?>
                      		<div class="col-xs-3 col-lg-4">
                                <div class="element header-liked">
                                    <a href="#office-auth-form" class="absolute fancyboxModal">
                                        <div class="table">
                                            <div class="table-cell text-center">
                                                <i class="material-icons <?= $hasFavorites ? 'active' : '' ?>">favorite</i>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        <?php endif ?>
                        <div class="col-xs-3 col-lg-4">
                            <div class="element header-lk">
                                <?php if (Yii::$app->user->isGuest): ?>
                                    <a href="#office-auth-form" class="absolute fancyboxModal">
                                        <div class="table">
                                            <div class="table-cell text-center">
                                                <i class="material-icons">account_circle</i>
                                            </div>
                                        </div>
                                    </a>
                                <?php else: ?>
                                    <a href="<?= Url::to(['user/settings/index']) ?>" class="absolute">
                                        <div class="table">
                                            <div class="table-cell text-center">
                                                <i class="material-icons active">account_circle</i>
                                            </div>
                                        </div>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-xs-3 col-lg-4">
                            <div class="element header-cart">
                                <!-- cart full -->

                                <a href="<?= Url::to(['user/cart/index']) ?>" class="absolute">
                                    <div class="table">
                                        <div class="table-cell text-center">
                                            <i class="material-icons">shopping_basket</i>
                                        </div>
                                    </div>
                                    <div class="header-cart-count">
                                        <div class="table">
                                            <div class="table-cell text-center">
                                                <span><?= Yii::$app->cart->count ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-xs-3 col-lg-4 visible-xs">
                            <div class="element mobile-menu-btn-wrapper">
                                <div class="table">
                                    <div class="table-cell">
                                        <div class="menu-button">
                                            <span class="icon-menu-burger">
                                                <span class="icon-menu-burger__line"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <nav class="header-menu hidden-xs">
                    <ul>
                        <li><a href="<?= Url::home() ?>"><span>Главная</span></a></li>
                        <li><a href="<?= Url::to(['/page/construction']) ?>"><span>Блог</span></a></li>
                        <li><a href="<?= Url::to(['news/index']) ?>"><span>Новости</span></a></li>
                    </ul>
                </nav>
                <div class="header-search">
                    <div class="push11"></div>
                    <div class="inner relative">
                        <form action="<?= Url::to(['/search/index']) ?>" type="POST">
                            <input type="text" name="search" placeholder="Поиск" value="<?=Yii::$app->getRequest()->get('search')?>"/>
                            <button type="submit">
                                <i class="material-icons">search</i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
	</noindex>
				
				
    <div class="header-push"></div>

<?php if (Yii::$app->user->isGuest): ?>
    <div class="modal" id="office-auth-form">
        <div class="inner">
            <div class="title bold upper f20 black">Авторизация</div>
            <div class="push20"></div>
            <?php $form = ActiveForm::begin([
                'action' => Url::to(['site/login']),
                'options' => ['class' => 'rf'],
                'enableClientValidation' => false,
                'validateOnBlur' => false,
                'validateOnChange' => false,
                'enableAjaxValidation' => true,
            ]) ?>

            <?= $form->field($login, 'username')->textInput([
                'placeholder' => 'Логин *',
                'class' => 'form-control required',
            ])->label(false) ?>

            <?= $form->field($login, 'password')->passwordInput([
                'placeholder' => 'Пароль *',
                'class' => 'form-control required',
            ])->label(false) ?>

            <div class="push20"></div>
            
            <div class="row min">
            	<div class="col-sm-5">
                	<input type="submit" class="btn block" value="Войти"/>
                    <div class="push20 visible-xs"></div>
                </div>
                <div class="col-sm-7">
                	<a href="#office-register-form" class="decoration btn btn-navy block fancyboxModal">Зарегистрироваться</a>
                </div>
            </div>
            <div class="push20"></div>
            <div class="text-center-xs text-left-sm">
            	<a href="<?= Url::to(['site/forgot']) ?>" class="decoration f14">Забыли пароль?</a>
            </div>
	
         

            <?php ActiveForm::end() ?>

            <div class="push25"></div>
<!--            <div class="social-login text-center roboto">-->
<!--                <div class="element-header relative"><span class="relative">или</span></div>-->
<!--                <div class="push20"></div>-->
<!--                <div class="title bold black upper f14">войти через соцсети</div>-->
<!--                <div class="push20"></div>-->
<!--                <a href="#" class="vk"><i class="fa fa-vk" aria-hidden="true"></i></a>-->
<!--                <a href="#" class="fb"><i class="fa fa-facebook" aria-hidden="true"></i></a>-->
<!--                <a href="#" class="google-plus"><i class="fa fa-google-plus" aria-hidden="true"></i></a>-->
<!--                <a href="#" class="yandex-btn"><img src="--><?//= Url::base() ?><!--/images/yandex2.svg" height="20"/></a>-->
<!--            </div>-->
        </div>
    </div>


    <div class="modal" id="office-register-form">
        <div class="inner">
            <div class="title bold upper f20 black">Регистрация</div>
            <div class="push20"></div>
            <?php $form = ActiveForm::begin([
                'id' => 'register-form',
                'action' => Url::to(['site/register']),
                'options' => ['class' => 'rf'],
                'enableClientValidation' => false,
                'validateOnBlur' => true,
                'validateOnChange' => true,
                'enableAjaxValidation' => true,
            ]) ?>

            <?= $form->field($register, 'username')->textInput([
                'placeholder' => 'Логин *',
                'class' => 'form-control required',
            ])->label(false) ?>

            <?= $form->field($register, 'email')->textInput([
                'placeholder' => 'Email *',
                'class' => 'form-control required',
            ])->label(false) ?>

            <?= $form->field($register, 'password1')->passwordInput([
                'placeholder' => 'Пароль *',
                'class' => 'form-control required pass1',
            ])->label(false) ?>

            <?= $form->field($register, 'password2')->passwordInput([
                'placeholder' => 'Пароль еще раз *',
                'class' => 'form-control required pass2',
            ])->label(false) ?>

            <div class="push10"></div>

            <?= $form->field($register, 'isAgree', [
                'options' => ['class' => 'customcheck m1'],
                'template' => "{input}\n<label for=\"agreement\">
                <i class=\"material-icons no-checked-icon\">check_box_outline_blank</i>
                <i class=\"material-icons checked-icon\">check_box</i>
                <small>Я принимаю <a href=\"/page/agreement\" class=\"decoration f14\" target=\"_blank\"><small>пользовательское соглашение</small></a> и подтверждаю, что ознакомлен 
                и согласен с <a href=\"/page/policy\" class=\"decoration f14\" target=\"_blank\"><small>политикой конфиденциальности</small></a> данного сайта.</small>
            </label><div class=\"push5\"></div>",
            ])->checkbox(['class' => 'required', 'id' => 'agreement'], false) ?>

            <?= $form->field($register, 'reCaptcha', [
                    'enableAjaxValidation' => false
            ])->widget(
                ReCaptcha3::className()
            )->label(false) ?>
            
            <div class="recaptcha-policy-text">
                This site is protected by reCAPTCHA and the Google
                <a href="https://policies.google.com/privacy">Privacy Policy</a> and
                <a href="https://policies.google.com/terms">Terms of Service</a> apply.
            </div>

            <div class="push20"></div>
			
          
          	<div class="row min">
              	<div class="col-sm-4 col-xs-5">
                  	<a href="#office-auth-form" class="btn btn-navy block fancyboxModal"><i class="fa fa-arrow-left hidden-xs" aria-hidden="true"></i> Назад</a>
                </div>
            	<div class="col-sm-8 col-xs-7">
                	<input type="submit" class="btn block" value="Регистрация"/>
                    <div class="push20 visible-xs"></div>
                </div>
            </div>
          	
            <?php ActiveForm::end() ?>

            <div class="push25"></div>
<!--            <div class="social-login text-center roboto">-->
<!--                <div class="element-header relative"><span class="relative">или</span></div>-->
<!--                <div class="push20"></div>-->
<!--                <div class="title bold black upper f14">регистрация через соцсети</div>-->
<!--                <div class="push20"></div>-->
<!--                <a href="#" class="vk"><i class="fa fa-vk" aria-hidden="true"></i></a>-->
<!--                <a href="#" class="fb"><i class="fa fa-facebook" aria-hidden="true"></i></a>-->
<!--                <a href="#" class="google-plus"><i class="fa fa-google-plus" aria-hidden="true"></i></a>-->
<!--                <a href="#" class="yandex-btn"><img src="--><?//= Url::base() ?><!--/images/yandex2.svg" height="20"/></a>-->
<!--            </div>-->
        </div>
    </div>
	
<?php endif; ?>
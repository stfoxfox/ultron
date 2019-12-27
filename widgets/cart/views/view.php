<?php

use yii\helpers\Html;

/** @var $template \app\models\Template */
/** @var $cartForm \app\models\CartForm */

?>

<div class="col-md-4 custom">
    <div class="aside-right">
        <div class="product-price-wrapper">
            <div class="element-header">
                <span class="upper bold f11">Стоимость:</span>
                <div class="right text-right">
                    <?php if ($template->price !== $template->actualPrice): ?>
                        <span class="old-price strike f14 red"><?= $template->price ?> р.</span>
                        <span class="product-price bold f18" data-price="<?= (int)$template->actualPrice ?>">
                            <?= $template->actualPrice ?> р.
                        </span>
                    <?php else: ?>
                        <span class="product-price bold f18" data-price="<?= (int)$template->price ?>">
                            <?php if ($template->is_free || $template->price == 0): ?>
                                Бесплатно
                            <?php else: ?>
                                <div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
								<span itemprop="price"><?= $template->price ?></span> р.
								<meta itemprop="priceCurrency" content="RUB">
								
								</div>
                            <?php endif; ?>
                        </span>
                    <?php endif; ?>
                </div>
                <div class="cleaner"></div>
            </div>

            <?= Html::beginForm(['user/cart/add'], 'post', ['id' => 'template-order-form']) ?>

            <?php if (count($template->services) > 0 || count($template->options) > 0): ?>
                <div class="element-body accordeon">
                    <?php if (count($template->services) > 0): ?>
                        <?= $this->render('_services', [
                            'services' => $template->services,
                            'cartForm' => $cartForm,
                        ]); ?>
                    <?php endif; ?>

                    <?php if (count($template->options) > 0): ?>
                        <?= $this->render('_options', [
                            'options' => $template->options,
                            'cartForm' => $cartForm,
                        ]); ?>
                    <?php endif; ?>
                </div>
            <?php endif ?>

            <?= Html::activeHiddenInput($cartForm, 'templateId') ?>
            <?= Html::endForm() ?>

            <div class="element-total text-right" style="<?= $template->actualPrice == 0 ? 'display:none;' : '' ?>">
                <span class="upper f12 weight600">Общая сумма: </span>
                <span class="total-summ bold f20">
                    <?= $template->actualPrice ?> р.
                </span>
            </div>

            
			<div class="element-footer">
                <div class="row min">
                    <?php if ($template->demo_url): ?>
                        <div class="col-sm-6">
                            <noindex><a href="<?= $template->demo_url ?>" target="_blank" rel="nofollow"
                               class="btn btn-navy block first">Демо <i class="material-icons">remove_red_eye</i></a>
                        </div></noindex>
                    <?php endif; ?>

                    <div class="<?= $template->demo_url ? 'col-sm-6' : '' ?>">

                        <noindex><button class="btn block" type="submit" id="order-template-button"
                                style="<?= $template->actualPrice == 0 ? 'display:none' : '' ?>">
                            <i class="material-icons">shopping_cart</i>
                            Заказать
                        </button></noindex>

                        <a href="<?= \yii\helpers\Url::to(['template/download', 'id' => $template->id]) ?>"
                           class="btn block" id="order-template-link"
                           style="<?= $template->actualPrice > 0 ? 'display:none' : '' ?>">
                            Скачать
                        </a>

                    </div>
                </div>
            </div>
			
        </div>
        <div class="push30"></div>
    </div>
</div>
<?php

use yii\helpers\Url;
use app\models\Download;

/** @var $this \yii\web\View */
/** @var $model \app\models\User */

$newVersionsCount = Download::getNewVersionsCount(Yii::$app->user->id);

?>

<div class="aside">
    <div class="push40"></div>
    <nav class="aside-menu">
        <div class="aside-menu-title visible-xs visible-sm">Категории ЛК</div>
        <ul>
            <li class="<?= $this->context->id === 'user/cart' ? 'active' : '' ?>">
                <a href="<?= Url::to(['user/cart/index']) ?>">Корзина</a>
            </li>

            <li class="<?= $this->context->id === 'user/settings' ? 'active' : '' ?>">
                <a href="<?= Url::to(['user/settings/index']) ?>">Настройки</a>
            </li>

            <li class="<?= $this->context->id === 'user/purchase' ? 'active' : '' ?>">
                <a href="<?= Url::to(['user/purchase/index']) ?>">Мои покупки
                    <?php if ($newVersionsCount > 0): ?>
                        <span class="update-counter"
                              title="Доступно <?= $newVersionsCount ?> обновление"><?= $newVersionsCount ?>
                            <i class="material-icons">announcement</i></span>
                    <?php endif; ?>
                </a>
            </li>

            <?php if (Yii::$app->user->isWebmaster): ?>
                <li class="<?= $this->context->route === 'user/template/upload' ? 'active' : '' ?>">
                    <a href="<?= Url::to(['user/template/upload']) ?>">Загрузить шаблон</a></li>
            <?php endif; ?>

            <?php if (Yii::$app->user->isWebmaster): ?>
                <li class="<?= $this->context->route === 'user/template/index' ? 'active' : '' ?>">
                    <a href="<?= Url::to(['user/template/index']) ?>">Мои шаблоны</a></li>
            <?php endif; ?>

            <?php if (Yii::$app->user->isWebmaster): ?>
                <li class="<?= $this->context->id === 'user/sale' ? 'active' : '' ?>">
                    <a href="<?= Url::to(['user/sale/index']) ?>">Продажи</a></li>
            <?php endif; ?>

            <?php if (Yii::$app->user->isWebmaster): ?>
                <li class="<?= $this->context->id === 'user/payout' ? 'active' : '' ?>">
                    <a href="<?= Url::to(['user/payout/index']) ?>">Выплаты</a></li>
            <?php endif; ?>

            <li class="<?= $this->context->id === 'user/help' ? 'active' : '' ?>">
                <a href="<?= Url::to(['user/help/index']) ?>">Помощь</a></li>
        </ul>
    </nav>
</div>
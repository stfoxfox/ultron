<?php

use yii\helpers\Url;
use yii\helpers\Html;

/** @var \yii\web\View $this */
/** @var \app\models\User $user */
/** @var int $templatesCount */
/** @var int $availableSum */
/** @var int $blockedSum */

?>

<div class="lk-header lk-<?= Yii::$app->user->isWebmaster ? 'seller' : 'buyer' ?>-header relative">
    <div class="lk-header-top-block">
        <div class="user-block relative">
            <div class="avatar">
                <?= Html::beginForm(['user/settings/avatar'], 'post', ['enctype' => 'multipart/form-data']) ?>
                <a href="#" title="Обновить фото">
                    <img src="<?= \app\components\File::src($user, 'picture', [100, 100]) ?>"/>
                </a>

                <?= Html::fileInput('User[picture]') ?>
                <?= Html::endForm() ?>

            </div>
            <div class="table">
                <div class="table-cell">
                    <div class="username red"><?= $user->username ?></div>
                    <span class="user-name"><?= $user->getDisplayName(); ?></span>
                </div>
            </div>
        </div>
        <a href="<?= Url::to(['site/logout']) ?>" class="logout-link">
            <i class="material-icons">exit_to_app</i> Выйти
        </a>
    </div>

    <?php if (Yii::$app->user->isWebmaster): ?>
        <div class="lk-header-middle-block">
            <div class="row">
                <div class="col-xs-4">
                    <div class="element text-center relative">
                        <a href="<?= Url::to(['user/template/index']) ?>" class="absolute"></a>
                        <div class="title gray">
                            <div class="table">
                                <div class="table-cell">
                                    Количество товаров:
                                </div>
                            </div>
                        </div>
                        <div class="text">
                            <b class="f18"><?= $templatesCount ?></b>
                            <!--
							<i class="material-icons help-icon">help</i>
                            <div class="hide">
                                Перейди по ссылке и узнай подробности партнерской программы, по которой сможешь
                                зарабатывать деньги,
                                просто делясь в соцсетях ссылками на наши шаблоны!
                            </div>
							-->
                        </div>
                    </div>
                </div>
                <div class="col-xs-4">
                    <div class="element text-center relative">
                        <!--<a href="<?= Url::to(['user/payout/index']) ?>" class="absolute"></a>-->
                        <div class="title gray">
                            <div class="table">
                                <div class="table-cell">
                                    Доступно к выплате:
                                </div>
                            </div>
                        </div>
                        <div class="text">
                            <b class="f18"><?= $availableSum ?> р.</b>
                            <i class="material-icons help-icon">help</i>
                            <div class="hide">
                                Выплата производится 1-3 числа каждого месяца за предыдущий месяц.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-4">
                    <div class="element text-center relative">
                        <?php if ($blockedSum): ?>
                        <a href="<?= Url::to(['user/sale/index']) ?>" class="absolute"></a>
                        <?php endif ?>
                        <div class="title gray">
                            <div class="table">
                                <div class="table-cell">
                                    Заблокированная сумма (HOLD):
                                </div>
                            </div>
                        </div>
                        <div class="text">
                            <b class="f18"><?= $blockedSum ?> р.</b>
                            <i class="material-icons help-icon">help</i>
                            <div class="hide">
                                Заблокированная для вывода сумма. Период блокировки 10 дней. По истечении периода блокировки сумма автоматически переходит к доступной к выплате.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
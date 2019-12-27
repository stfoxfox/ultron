<?php

use app\widgets\topmenu\TopMenu;
use app\models\User;

/** @var $this \yii\web\View */
/** @var $model \app\models\SellerRequest */

?>

<?= TopMenu::widget() ?>

<div class="middle">
    <div class="container">
        <div class="push30"></div>
        <div class="push30 hidden-xs hidden-sm"></div>

        <div class="container-min">
            <div class="title-h2">Регистрация на сайте</div>

            <div class="alert alert-success">
                Ваша учетная запись была успешно активирована.
                <?php if ($model->status === User::STATUS_PENDING): ?>
                    <br> Вы сможете войти на сайт после проверки модератором.
                <?php endif ?>
            </div>

        </div>
    </div>

    <div class="push50"></div>
</div>
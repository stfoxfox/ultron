<?php

use yii\widgets\ActiveForm;
use app\widgets\topmenu\TopMenu;

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

            <?php if (Yii::$app->session->hasFlash('register-success')): ?>
                <div class="alert alert-success">
                    <?= Yii::$app->session->getFlash('register-success') ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="push50"></div>
</div>
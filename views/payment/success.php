<?php

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
            <div class="title-h2"><?= $header ?></div>

            <p>
                <?= $message ?>
            </p>

            <?= \yii\helpers\Html::a('Перейти в личный кабинет', ['/user/purchase/index'], ['class' => 'btn btn success']) ?>
        </div>
    </div>

    <div class="push50"></div>
</div>
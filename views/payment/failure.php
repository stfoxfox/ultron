<?php

use app\widgets\topmenu\TopMenu;

/** @var $this \yii\web\View */
/** @var $model \app\models\SellerRequest */
/** @var $snippet \app\models\Snippet */

?>

<?= TopMenu::widget() ?>

<div class="middle">
    <div class="container">
        <div class="push30"></div>
        <div class="push30 hidden-xs hidden-sm"></div>

        <div class="container-min">
            <div class="title-h2"><?= $snippet->description ?></div>

            <p>
                <?= $snippet->value ?>
            </p>

            <?= \yii\helpers\Html::a('Верутся на главную', ['/'], ['class' => 'btn btn success']) ?>
        </div>
    </div>

    <div class="push50"></div>
</div>
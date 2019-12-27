<?php

use app\widgets\profileblock\ProfileBlock;
use app\widgets\topmenu\TopMenu;
use kroshilin\yakassa\widgets\Payment;

/* @var $order app\models\Invoice */
/* @var $user app\models\User */

?>

<?= TopMenu::widget() ?>

<div class="middle">
    <div class="lk lk-buyer">
        <div class="container">

            <?php if (!Yii::$app->user->isGuest): ?>
                <?= ProfileBlock::widget(); ?>
            <?php endif; ?>

            <div class="row">

                <?= Payment::widget([
                    'order' => $order,
                    'userIdentity' => Yii::$app->user->identity,
                    'data' => ['customParam' => 'value'],
                    'paymentType' => ['PC' => 'Со счета в Яндекс.Деньгах', 'AC' => 'С банковской карты']
                ]); ?>

            </div>
        </div>
    </div>

    <div class="push50"></div>
</div>

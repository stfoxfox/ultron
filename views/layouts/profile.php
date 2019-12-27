<?php

use app\widgets\profileblock\ProfileBlock;
use app\widgets\topmenu\TopMenu;

/** @var $content string */


?>

<?php $this->beginContent('@app/views/layouts/main.php'); ?>

<?= TopMenu::widget() ?>

<div class="middle">
    <div class="lk lk-seller">
        <div class="container">
            <div class="push30"></div>

            <?php if (!Yii::$app->user->isGuest): ?>
                <?= ProfileBlock::widget(); ?>
            <?php endif; ?>

            <div class="row">

                <?php if (!Yii::$app->user->isGuest): ?>
                    <div class="col-md-4 col-lg-3">
                        <?= $this->render('../user/_sidebar') ?>
                    </div>
                <?php endif; ?>

                <div class="col-md-8 col-lg-9">
                    <div class="main-column">

                        <?php if (!Yii::$app->user->isGuest): ?>
                        <div class="push40 hidden-xs hidden-sm"></div>
                        <?php endif ?>

                        <? if (Yii::$app->session->hasFlash('success')): ?>
                            <?= \yii\bootstrap\Alert::widget([
                                'body' => Yii::$app->session->getFlash('success'),
                                'options' => [
                                    'class' => 'alert-success',
                                ],
                            ]) ?>
                        <? endif; ?>

                        <?= $content ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="push50"></div>
</div>

<?php $this->endContent(); ?>
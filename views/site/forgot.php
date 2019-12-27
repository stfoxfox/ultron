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
            <div class="title-h2">Восстановление пароля</div>

            <?php if (Yii::$app->session->hasFlash('forgot.send')): ?>
                <div class="alert alert-success">
                    <?= Yii::$app->session->getFlash('forgot.send') ?>
                </div>
            <?php elseif (Yii::$app->session->hasFlash('forgot.success')): ?>
                <div class="alert alert-success">
                    <?= Yii::$app->session->getFlash('forgot.success') ?>
                </div>
            <?php elseif (Yii::$app->session->hasFlash('forgot.error')): ?>
                <div class="alert alert-success">
                    <?= Yii::$app->session->getFlash('forgot.error') ?>
                </div>
            <?php else: ?>
                <?php $form = ActiveForm::begin([
                    'id' => 'forgot-form',
                    'options' => ['class' => 'rf'],
                    'enableClientValidation' => false,
                    'validateOnBlur' => false,
                    'validateOnChange' => false,
                    'enableAjaxValidation' => true,
                ]) ?>

                <div class="row">
                    <div class="col-md-4">
                        <?= $form->field($model, 'usernameOrEmail')->textInput([
                            'class' => 'form-control required',
                        ]) ?>

                        <input type="submit" value="Отправить" class="btn">
                    </div>
                </div>

                <div class="push25"></div>

                <?php ActiveForm::end() ?>
            <?php endif; ?>

        </div>
    </div>

    <div class="push50"></div>
</div>
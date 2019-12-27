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
            <div class="title-h2"><?= \app\models\Snippet::findByKey('seller-form-header')->value ?></div>

            <?php if (Yii::$app->session->hasFlash('seller')): ?>
                <?= Yii::$app->session->getFlash('seller') ?>
            <?php else: ?>
                <div class="content f14">
                    <?= \app\models\Snippet::findByKey('seller-form-content')->value ?>
                </div>
                <div class="push1"></div>
                <hr/>
                <div class="push10"></div>
                <div class="row">
                    <div class="col-md-6">

                        <?php $form = ActiveForm::begin(['options' => ['class' => 'rf']]) ?>

                        <?= $form->field($model, 'name')->textInput([
                            'class' => 'form-control required',
                        ])->label('Имя *') ?>

                        <?= $form->field($model, 'email')->textInput([
                            'class' => 'form-control required',
                        ])->label('Email *') ?>

                        <?= $form->field($model, 'skype')->textInput([
                            'class' => 'form-control',
                        ])->label('Skype') ?>

                        <?= $form->field($model, 'message')->textarea([
                            'class' => 'form-control',
                        ])->label('Сообщение') ?>

                        <p>
                            <small>* - поля, обязательные для заполнения</small>
                        </p>

                        <div class="push15"></div>
                        <input type="submit" class="btn" value="Отправить"/>

                        <?php ActiveForm::end() ?>

                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="push50"></div>
</div>
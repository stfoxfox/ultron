<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'Вход в панель управления';
?>
<body class="gray-bg">
<div class="middle-box text-center"
     style="width: 300px;margin-top:-200px;margin-left: -150px;">
    <div>
        <h3 style="margin-bottom: 40px;">Вход в панель управления</h3>

        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
        <div class="form-group">
            <?= $form->field($model, 'username') ?>
        </div>
        <div class="form-group">
            <?= $form->field($model, 'password')->passwordInput() ?>
        </div>
        <?= Html::submitButton('Войти &rarr;', ['class' => 'btn btn-primary block full-width m-b', 'name' => 'login-button']) ?>
        <?php ActiveForm::end(); ?>
        <p class="m-t">
            <small><?= Yii::$app->request->serverName ?> &copy; <?= date('Y') ?></small>
        </p>
    </div>
</div>
</body>
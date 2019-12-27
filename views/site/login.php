<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\widgets\topmenu\TopMenu;

$this->title = 'Войти';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= TopMenu::widget() ?>

<div class="middle">
    <div class="container">
        <div class="push30"></div>
        <div class="push30 hidden-xs hidden-sm"></div>

        <div class="container-min">
            <h1><?= Html::encode($this->title) ?></h1>

<!--            <div class="row">-->
<!--                --><?php //echo yii\authclient\widgets\AuthChoice::widget([
//                    'baseAuthUrl' => ['auth/network/auth']
//                ]); ?>
<!--            </div>-->
            <div class="row">
                <div class="col-md-6">
                    <?php $form = ActiveForm::begin([
                        'id' => 'login-form',
                        'layout' => 'horizontal',
                        'fieldConfig' => [
                            'template' => "{label}\n<div>{input}</div>\n<div>{error}</div>",
                            'labelOptions' => ['class' => 'control-label'],
                        ],
                    ]); ?>
        
                        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
        
                        <?= $form->field($model, 'password')->passwordInput() ?>
        
                        <?= $form->field($model, 'rememberMe')->checkbox([
                            'template' => "<div>{input} {label}</div>\n<div>{error}</div>",
                        ]) ?>
                        
                        <div class="push20"></div>
                        <div class="form-group">
                            <div>
                                <?= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                            </div>
                        </div>
        
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="push50"></div>
</div>
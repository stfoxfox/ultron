<?php

use app\components\inspinia\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title"></div>

            <div class="ibox-content">

                <?php $form = ActiveForm::begin(['id' => 'user-form']); ?>

                <?= Html::errorSummary($model, ['class' => 'alert alert-danger']) ?>

                <?php if (!$model->isNewRecord): ?>
                    <?= $form->field($model, 'id')->textInput(['readonly' => true]) ?>
                <?php endif; ?>

                <?= $form->field($model, 'username')->textInput(['readonly' => !$model->isNewRecord]) ?>
                <?= $form->field($model, 'email') ?>
                <?= $form->field($model, 'status')->dropDownList(User::getStatuses()) ?>

                <?= $form->field($model, 'first_name') ?>
                <?= $form->field($model, 'last_name') ?>
                <?= $form->field($model, 'phone') ?>
                <?= $form->field($model, 'comment')->textarea() ?>

                <?php if (!$model->isNewRecord): ?>
                    <?= $form->field($model, 'created_at')->textInput(['readonly' => true]) ?>
                    <?= $form->field($model, 'last_visit')->textInput(['readonly' => true]) ?>
                <?php endif; ?>

                <div class="hr-line-dashed"></div>

                <?= $form->field($model, 'password1')->passwordInput() ?>
                <?= $form->field($model, 'password2')->passwordInput() ?>

                <div class="hr-line-dashed"></div>

                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2">
                        <a href="<?= Url::to(['index']) ?>"
                           class="btn btn-white">&larr; Вернуться назад</a>

                        <button class="btn btn-primary" type="submit"
                                onclick="return confirm('Вы действительно хотите сохранить изменения?')">
                            Сохранить
                        </button>
                    </div>
                </div>
                <?php ActiveForm::end() ?>
            </div>
        </div>
    </div>
</div>
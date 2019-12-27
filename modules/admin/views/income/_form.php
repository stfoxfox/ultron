<?php

use app\components\inspinia\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use app\models\User;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Invoice */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title"></div>

            <div class="ibox-content">

                <?php $form = ActiveForm::begin([
                    'id' => 'page-form',
                ]); ?>

                <?= Html::errorSummary($model, ['class' => 'alert alert-danger']) ?>

                <?= $form->field($model, 'sum') ?>
                <?= $form->field($model, 'user_id')->dropDownList(ArrayHelper::map(User::find()->all(), 'id', 'username'))
                    ->label('Вебмастер') ?>
                <?= $form->field($model, 'status')->dropDownList(\app\models\Payout::getStatuses())->label('Статус выплаты') ?>
                <?= $form->field($model, 'file')->fileInput() ?>

                <?php if ($model->picture): ?>
                    <div class="form-group">
                        <div class="col-lg-3 control-label"></div>
                        <div class="col-lg-6">
                            <img src="<?= \app\components\File::src($model, 'picture', [100, 100]) ?>" alt=""/>
                        </div>
                    </div>
                <?php endif ?>


                <?= $form->field($model, 'payment_type')->dropDownList(\app\models\Payout::getPaymentTypes($model->user_id)) ?>
                <?= $form->field($model, 'comment')->textarea() ?>
                <?= $form->field($model, 'created_at')->widget(\yii\jui\DatePicker::class, [
                    'dateFormat' => 'dd.MM.yyyy',
                    'options' => ['class' => 'form-control'],
                ]) ?>

                <div class="hr-line-dashed"></div>

                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2">
                        <a href="<?= Url::to(['index']) ?>"
                           class="btn btn-white">&larr; Вернуться назад</a>

                        <button class="btn btn-primary" type="submit">
                            Сохранить
                        </button>
                    </div>
                </div>
                <?php ActiveForm::end() ?>
            </div>
        </div>
    </div>
</div>
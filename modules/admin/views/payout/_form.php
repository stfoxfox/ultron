<?php

use app\components\inspinia\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use app\models\Payout;

/* @var $this yii\web\View */
/* @var $model app\models\Invoice */
/* @var $form yii\widgets\ActiveForm */
/* @var $user \app\models\User */

?>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title"></div>

            <div class="ibox-content">

                <?php $form = ActiveForm::begin([
                    'id' => 'page-form',
                    'enableClientValidation' => false,
                    'enableAjaxValidation' => true,
                    'validateOnChange' => true,
                ]); ?>

                <?= Html::errorSummary($model, ['class' => 'alert alert-danger']) ?>

                <div class="form-group">
                    <label class="control-label col-sm-3">Вебмастер</label>
                    <div class="col-sm-6"><a style="line-height: 35px;"
                                             href="<?= Url::to(['/admin/webmaster/view', 'id' => $user->id]) ?>"><?= $user->username ?></a>
                    </div>
                </div>

                <?= $form->field($model, 'sum')->textInput(['value' => $user->getAvailableIncome()]) ?>

                <div class="form-group" style="margin-top: -15px;">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-6">
                        Максимальная сумма к выплате <a href="#"
                                                        data-payout-max-sum="<?= $user->getAvailableIncome() ?>"><?= $user->getAvailableIncome() ?></a>
                        р.
                    </div>
                </div>

                <?= $form->field($model, 'file')->fileInput() ?>

                <?php if ($model->picture): ?>
                    <div class="form-group">
                        <div class="col-lg-3 control-label"></div>
                        <div class="col-lg-6">
                            <img src="<?= \app\components\File::src($model, 'picture', [100, 100]) ?>" alt=""/>
                        </div>
                    </div>
                <?php endif ?>

                <?= $form->field($model, 'payment_type')->dropDownList(\app\models\Payout::getPaymentTypes($model->user_id), [
                    'value' => $user->default_payment_system
                ]) ?>
                <div class="form-group" style="margin-top: -15px;">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-6">
                        <?php if (isset(Payout::getPaymentTypes($model->user_id)[$user->default_payment_system])): ?>
                            Предпочитаемая платежная
                            система <a href="#"
                                       data-payout-preferred-system="<?= $user->default_payment_system ?>"><?= Payout::getPaymentTypes($model->user_id)[$user->default_payment_system] ?></a>
                        <?php else: ?>
                            Предпочитаемая платежная
                            система не выбрана
                        <?php endif; ?>
                    </div>
                </div>

                <?= $form->field($model, 'comment')->textarea() ?>
                <?= $form->field($model, 'created_at')->widget(\yii\jui\DatePicker::class, [
                    'dateFormat' => 'dd.MM.yyyy',
                    'options' => ['class' => 'form-control'],
                ]) ?>

                <div class="hr-line-dashed"></div>

                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2">
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
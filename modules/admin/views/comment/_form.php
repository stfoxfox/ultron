<?php

use app\components\inspinia\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use vova07\imperavi\Widget;

/* @var $this yii\web\View */
/* @var $model app\models\Comment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title"></div>

            <div class="ibox-content">

                <?php $form = ActiveForm::begin([
                    'id' => 'news-form',
                    'options' => [
                        'enctype' => 'multipart/form-data',
                    ],
                ]); ?>

                <?= Html::errorSummary($model, ['class' => 'alert alert-danger']) ?>

                <div class="form-group">
                    <label class="control-label col-sm-3">Товар</label>
                    <div class="col-sm-6">
                        <a href="<?= Url::to(['/admin/template/update', 'id' => $model->template_id]); ?>">
                            <?= $model->template->title ?>
                        </a>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-3">Пользователь</label>
                    <div class="col-sm-6">
                        <a href="<?= Url::to($model->user->getUserRoute()); ?>">
                            <?= $model->user->username ?>
                        </a>
                    </div>
                </div>

                <?= $form->field($model, 'score')->textInput(['disabled' => true]) ?>
                <?= $form->field($model, 'message')->textarea() ?>
                <?= $form->field($model, 'answer')->widget(Widget::className(), ['settings' => ['lang' => 'ru']]); ?>

                <?= $form->field($model, 'is_published')->checkbox() ?>

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
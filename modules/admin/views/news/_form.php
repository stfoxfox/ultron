<?php

use app\components\inspinia\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use vova07\imperavi\Widget;

/* @var $this yii\web\View */
/* @var $model app\models\News */
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

                <?= $form->field($model, 'title') ?>

                <?= $form->field($model, 'file')->fileInput() ?>

                <?php if ($model->picture): ?>
                    <div class="form-group">
                        <div class="col-lg-3 control-label"></div>
                        <div class="col-lg-6">
                            <img
                                    src="<?= \app\components\File::src($model, 'picture', [100, 100]) ?>"
                                    alt=""/>
                        </div>
                    </div>
                <?php endif ?>

                <div class="hr-line-dashed"></div>

                <?= $form->field($model, 'content_short')->widget(Widget::className(), ['settings' => ['lang' => 'ru']]); ?>
                <?= $form->field($model, 'content')->widget(Widget::className(), ['settings' => ['lang' => 'ru']]); ?>

                <?= $form->field($model, 'meta_keywords')->textarea() ?>
                <?= $form->field($model, 'meta_description')->textarea() ?>

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
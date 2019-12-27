<?php

use app\components\inspinia\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use app\components\File;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model app\models\Type */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title"></div>

            <div class="ibox-content">

                <?php $form = ActiveForm::begin([
                    'id' => 'form',
                    'options' => [
                        'enctype' => 'multipart/form-data',
                    ],
                ]); ?>

                <?= Html::errorSummary($model, ['class' => 'alert alert-danger']) ?>

                <?= $form->field($model, 'file')->fileInput() ?>

                <?php if ($model->picture): ?>
                    <div class="form-group">
                        <div class="col-lg-3 control-label"></div>
                        <div class="col-lg-6">
                            <img src="<?= File::src($model, 'picture', [100, 100]) ?>" alt=""/>
                        </div>
                    </div>
                <?php endif ?>

                <?= $form->field($model, 'title') ?>
                <?= $form->field($model, 'short_title') ?>
                <?= $form->field($model, 'alias') ?>
                <?= $form->field($model, 'description')->textarea() ?>
                <?= $form->field($model, 'ordering') ?>
                <?= $form->field($model, 'page_text')->widget(CKEditor::className(), [
                    'options' => ['rows' => 6],
                    'preset' => 'full'
                ]) ?>

                <?= $form->field($model, 'meta_title')->textarea() ?>
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
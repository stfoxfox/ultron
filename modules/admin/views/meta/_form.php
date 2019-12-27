<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\components\inspinia\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Meta */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title"></div>

            <div class="ibox-content">

                <?php $form = ActiveForm::begin([
                    'id' => 'meta-form',
                    'options' => ['class' => 'form-horizontal']
                ]); ?>

                <?= $form->field($model, 'route')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'title')->textarea(['rows' => 3]) ?>

                <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

                <?= $form->field($model, 'keywords')->textarea(['rows' => 6]) ?>

<!--                --><?//= $form->field($model, 'tags')->textarea(['rows' => 6]) ?>

                <div class="hr-line-dashed"></div>

                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2">
                        <a href="<?= Url::to(['index']) ?>"
                           class="btn btn-white">&larr; Вернуться назад</a>

                        <button class="btn btn-primary" type="submit">
                            Сохранить
                        </button>
                    </div>
<!--                    <div class="clear"></div>-->
                </div>

                <?php ActiveForm::end(); ?>


            </div>
        </div>
    </div>
</div>

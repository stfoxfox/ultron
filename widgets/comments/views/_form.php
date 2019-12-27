<?php

use yii\widgets\ActiveForm;

/** @var \app\models\Comment $comment */
/** @var \app\models\Template $template */

?>

<div class="rev-form">
    <div class="push20"></div>
    <div class="row">
        <div class="col-sm-9 col-md-12">
            <?php $form = ActiveForm::begin([
                'id' => 'comment-form',
                'action' => ['comment/create', 'id' => $template->id],
                'options' => ['class' => 'rf'],
            ]) ?>
            <div class="row">
                <div class="col-sm-6">
                    <div class="title black upper bold">Оставить отзыв</div>
                </div>
                <div class="col-sm-6">
                    <div class="rating-add-block text-right-sm">
                        <span data-rating="1">
                            <i class="material-icons icon">star_border</i>
                            <i class="material-icons icon-active">star</i>
                        </span>
                        <span data-rating="2">
                            <i class="material-icons icon">star_border</i>
                            <i class="material-icons icon-active">star</i>
                        </span>
                        <span data-rating="3">
                            <i class="material-icons icon">star_border</i>
                            <i class="material-icons icon-active">star</i>
                        </span>
                        <span data-rating="4">
                            <i class="material-icons icon">star_border</i>
                            <i class="material-icons icon-active">star</i>
                        </span>
                        <span data-rating="5">
                            <i class="material-icons icon">star_border</i>
                            <i class="material-icons icon-active">star</i>
                        </span>
                    </div>
                </div>
            </div>

            <div class="push10"></div>

            <div class="row min">
                <div class="col-sm-6">
                    <div class="form-group">
                        <?= $form->field($comment, 'name')->textInput([
                            'class' => 'form-control required',
                            'placeholder' => 'Ваше имя *',
                            'id' => 'ec-user_name-resource-10',
                        ]) ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <?= $form->field($comment, 'email')->textInput([
                            'class' => 'form-control required',
                            'placeholder' => 'E-mail',
                            'id' => 'ec-user_email-resource-10',
                        ]) ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <?= $form->field($comment, 'message')->textarea([
                    'class' => 'form-control required',
                    'placeholder' => 'Ваш отзыв',
                    'id' => 'ec-text-resource-10',
                ]) ?>
            </div>
            <p>
                <small>* - поля, обязательные для заполнения</small>
            </p>

            <input type="submit" class="button btn min" value="Отправить"/>

            <?= $form->field($comment, 'score')->hiddenInput()->label(false) ?>
            <?php ActiveForm::end() ?>

            <div id="ec-form-success-resource-10"></div>
        </div>
    </div>
</div>
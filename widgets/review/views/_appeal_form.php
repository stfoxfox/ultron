<?php

/**
 * Comments widget form view.
 * @var \yii\web\View $this View
 * @var \yii\widgets\ActiveForm $form Form
 * @var \app\models\AppealForm $model
 */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\captcha\Captcha;
use dosamigos\ckeditor\CKEditor;

?>
<?php $form = ActiveForm::begin([
    'id' => 'appeal-form',
    'action' => ['review/appeal', 'id'=>$model->template_id],
    'options' => [
        'class' => 'form-horizontal',
        'data-comment' => 'appeal-form',
        'data-comment-action' => 'appeal',
        'data-comment-id' => $model->template_id
    ],
]);
?>
    <div class="form-group" data-comment="form-group">
    <div class="col-sm-12">
        <?= $form->field($model, 'content')->widget(CKEditor::className(), [
            'options' => ['rows' => 6],
            'preset' => 'basic'
        ])
        ->label(false)?>
    </div>
</div>
<?php
echo $form->field($model, 'verifyCode')->widget(
    Captcha::class,
    [
        'captchaAction' => '/site/captcha',
        'options' => ['class' => 'form-control'],
        'imageOptions' => [
            'class' => 'appeal-captcha-image',
            'id' => 'appeal-captcha-image',
        ],
        'template' => '<div class="row captcha-row"><div class="col-xs-5 col-lg-3">{image}</div><div class="col-xs-7 col-lg-9">{input}</div></div>',
        'imageOptions' => [
            'style' => 'height: 40px'
        ]
    ]
)
->label(false)?>
<?= Html::submitButton('Пожаловаться', ['class' => 'btn btn-danger btn-lg']); ?>
<?php ActiveForm::end() ?>
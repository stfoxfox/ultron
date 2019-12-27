<?php

/**
 * Comments widget form view.
 * @var \yii\web\View $this View
 * @var \yii\widgets\ActiveForm $form Form
 * @var \app\models\Review $model New review model
 */

use vova07\comments\Module;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;
use dosamigos\ckeditor\CKEditor;

?>
<?php $form = ActiveForm::begin([
    'id' => 'review-form-create',
    'action' => ['review/create'],
    'options' => [
        'class' => 'form-horizontal',
        'data-comment' => 'form',
        'data-comment-action' => 'create'
    ],
]);
?>
<div class="form-group" data-comment="form-group">
    <div class="col-sm-12">
        <?= $form->field($model, 'content')->widget(CKEditor::class, [
            'options' => ['rows' => 6],
            'preset' => 'basic'
        ])
        ->label(false)?>
    </div>
</div>
<?= Html::activeHiddenInput($model, 'parent_id', ['data-comment' => 'parent-id']) ?>
<?= Html::activeHiddenInput($model, 'model_class') ?>
<?= Html::activeHiddenInput($model, 'model_id') ?>
<?php
//echo $form->field($model, 'verifyCode')->widget(
//    Captcha::class,
//    [
//        'captchaAction' => '/site/captcha',
//        'options' => ['class' => 'form-control'],
//        'template' => '<div class="row captcha-row"><div class="col-xs-5 col-lg-3">{image}</div><div class="col-xs-7 col-lg-9">{input}</div></div>',
//        'imageOptions' => [
//            'style' => 'height: 40px'
//        ]
//    ]
//)
//->label(false);
?>
<?= Html::activeCheckbox($model,'receive_flag', [
    'class' => 'js-receive-flag',
    'data-url' => \yii\helpers\Url::to(['/review/template-notice-toggle', 'template_id'=>$model->model_id])
]) ?>
<div style="clear: both"></div>
<?= Html::submitButton(Module::t('comments', 'FRONTEND_WIDGET_COMMENTS_FORM_SUBMIT'), ['class' => 'btn btn-danger btn-lg']); ?>
<?php ActiveForm::end() ?>

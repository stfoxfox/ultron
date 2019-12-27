<?php

use app\components\inspinia\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use vova07\imperavi\Widget;
use app\models\Template;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Template */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <span class="webmaster">
                    <?= Html::a('&nbsp;&nbsp;&nbsp;Скачать архив: <i class="fa fa-download"></i>',
                        [
                            '/template/download',
                            'id' => $model->id
                        ],
                        [
                            'class' => "download-archive",
                            'title' => "Скачать архив шаблона"
                        ]
                    ) ?>
                </span>
                <span class="webmaster">
                    Webmaster:
                    <?= Html::a($model->user->username, ['webmaster/view', 'id' => $model->user->id]) ?>
                </span>
            </div>

            <div class="ibox-content">

                <div class="row img-view">
                    <div class="inline col-md-3"></div>
                    <? foreach ($model->pictures as $picture): ?>
                        <div class="inline col-md-2">
                            <div class="thumbnail">
                                <?= \app\components\File::img($picture, 'file_name', [133, 133], [
                                    'style' => 'min-height: 100%;',
                                ]) ?>
                            </div>
                        </div>
                    <? endforeach ?>
                </div>

                <?php $form = ActiveForm::begin([
                    'id' => 'page-form',
                ]); ?>

                <?= Html::errorSummary($model, ['class' => 'alert alert-danger']) ?>

                <?php if (!$model->isNewRecord): ?>
                    <?= $form->field($model, 'displayArticle')->textInput([
                        'disabled' => true,
                    ]) ?>
                <?php endif; ?>

                <?= $form->field($model, 'title') ?>

                <?php if (count($model->files) > 0): ?>
                    <div class="form-group">
                        <label class="control-label col-sm-3" style="position: relative;margin-top: -2px;">
                            Загруженные файлы
                        </label>
                        <div class="col-sm-6" style="position: relative;margin-top: 5px;">
                            <?php foreach ($model->files as $file): ?>
                                <a href="<?= Url::to(['download', 'id' => $file->id]) ?>" target="_blank">
                                    <?= $file->original_name ?>
                                </a> <br>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif ?>

                <?= $form->field($model, 'type_id')->dropDownList(\app\models\Type::getTypes()) ?>
                <?= $form->field($model, 'price') ?>
                <?= $form->field($model, 'new_price') ?>

                <?= $form->field($model, 'discount_date')->widget(DatePicker::class, [
                    'options' => ['class' => 'form-control'],
                    'dateFormat' => 'dd.MM.yyyy',
                ]) ?>

                <?= $form->field($model, 'is_free')->checkbox(['id' => 'free_template']) ?>

                <?= $form->field($model, 'option_ids')->dropDownList(\app\models\Option::getOptions(), ['multiple' => true]) ?>
                <?= $form->field($model, 'service_ids')->dropDownList(\app\models\Service::getServices(), ['multiple' => true]) ?>
                <?= $form->field($model, 'category_ids')->dropDownList(\app\models\Category::getCategories(), ['multiple' => true]) ?>
                <?= $form->field($model, 'tag_ids')->dropDownList(\app\models\Tag::getTags(\yii\helpers\ArrayHelper::map($model->categories, 'id', 'id')), [
                    'multiple' => true,
                    'data-url' => Url::to(['template/tags']),
                ]) ?>

                <?= $form->field($model, 'demo_url') ?>
                <?= $form->field($model, 'description')->widget(Widget::className(), ['settings' => ['lang' => 'ru']]); ?>
                <?= $form->field($model, 'features')->widget(Widget::className(), ['settings' => ['lang' => 'ru']]); ?>
                <?= $form->field($model, 'version_history')->widget(Widget::className(), ['settings' => ['lang' => 'ru']]); ?>
                <?= $form->field($model, 'status')->dropDownList(Template::getStatuses()) ?>
                <?= $form->field($model, 'moderate_status')->dropDownList(Template::getModerateStatuses()) ?>

                <div class="hr-line-dashed"></div>

                <?= $form->field($model, 'order')->textInput() ?>

                <div class="hr-line-dashed"></div>

                <?= $form->field($model, 'meta_title')->textarea() ?>
                <?= $form->field($model, 'meta_description')->textarea() ?>
                <?= $form->field($model, 'meta_keywords')->textarea() ?>

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
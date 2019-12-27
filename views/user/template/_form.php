<?php

use yii\widgets\ActiveForm;
use app\models\Category;
use app\models\Tag;
use yii\helpers\Html;
use app\models\Snippet;

/** @var $this \yii\web\View */
/** @var $model \app\models\Template */
/** @var $templateFile \app\models\TemplateFile */

?>

<?php $form = ActiveForm::begin([
    'id' => 'upload-template-form',
    'enableClientValidation' => true,
    'enableAjaxValidation' => false,
    'options' => [
        'class' => 'rf',
        'enctype' => 'multipart/form-data',
    ],
]) ?>

<?= $form->errorSummary($model) ?>

    <div class="row">
        <div class="col-sm-6 col-lg-5">
            <?= $form->field($model, 'title', [
                'template' => "{label}\n<i class=\"material-icons help-icon\">help</i>
                                        <div class=\"hide\">" . Snippet::findByKey('template-hint-title')->value . "</div>
                                        <div class=\"push5\"></div>\n{input}\n{error}",
            ])->textInput([
                'class' => 'form-control required',
            ]) ?>
        </div>
        <div class="col-sm-6 col-lg-5">
            <?= $form->field($model, 'type_id', [
                'template' => "{label}\n<i class=\"material-icons help-icon\">help</i>
                                        <div class=\"hide\">" . Snippet::findByKey('template-hint-type')->value . "</div>
                                        <div class=\"push5\"></div>\n{input}\n{error}",
            ])->dropDownList(\app\models\Type::getTypes(), [
                'class' => 'select-styler big required',
                'data-placeholder' => 'Выберите тип',
                'prompt' => '',
            ]) ?>
        </div>
    </div>
    <div class="push10"></div>

    <div class="row">
        <div class="col-sm-6 col-lg-5">
            <?= $form->field($model, 'demo_url', [
                'template' => "{label}\n<i class=\"material-icons help-icon\">help</i>
                                        <div class=\"hide\">" . Snippet::findByKey('template-hint-demo-url')->value . "</div>
                                        <div class=\"push5\"></div>\n{input}\n{error}",
            ])->textInput([
                'class' => 'form-control',
            ]) ?>
        </div>
        <div class="col-sm-6 col-lg-5">
            <?= $form->field($model, 'category_ids', [
                'template' => "{label}\n<i class=\"material-icons help-icon\">help</i>
                                        <div class=\"hide\">" . Snippet::findByKey('template-hint-categories')->value . "</div>
                                        <div class=\"push5\"></div>\n{input}\n{error}",
            ])->dropDownList(Category::getCategories(), [
                'class' => 'chosen-select required',
                'data-placeholder' => 'Выберите до 5 категорий шаблона',
                'multiple' => true,
                'prompt' => '',
            ]) ?>
        </div>
    </div>
    <div class="push10"></div>

    <div class="row">
        <div class="col-sm-10 col-lg-5">
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'price', [
                        'template' => "{label}\n<i class=\"material-icons help-icon\">help</i>
                                        <div class=\"hide\">" . Snippet::findByKey('template-hint-price')->value . "</div>
                                        <div class=\"push5\"></div>\n{input}\n{error}",
                    ])->textInput([
                        'class' => 'form-control num',
                        'id' => 'price_input',
                        'disabled' => $model->is_free == 1,
                    ]) ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'new_price', [
                        'template' => "{label}\n<i class=\"material-icons help-icon\">help</i>
                                        <div class=\"hide\">" . Snippet::findByKey('template-hint-new-price')->value . "</div>
                                        <div class=\"push5\"></div>\n{input}\n{error}",
                    ])->textInput([
                        'class' => 'form-control num',
                        'id' => 'price_input_new',
                        'disabled' => $model->is_free == 1,
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="col-sm-10 col-lg-10">
<!--            --><?php //= $form->field($model, 'discount_date', [
//                'template' => "{label}\n<i class=\"material-icons help-icon\">help</i>\n<div class=\"hide\">
//                                            " . Snippet::findByKey('template-hint-discount-date')->value . "</div>\n<div class=\"push5\"></div>\n{input}",
//            ])->textInput([
//                'value' => !empty($model->discount_date) ? date('d.m.Y', strtotime($model->discount_date)) : null,
//                'class' => 'form-control num',
//                'id' => 'action_date_input',
//                'disabled' => $model->is_free == 1,
//            ]) ?>
            <div class="form-group field-action_date_input">
                <label class="control-label" for="action_date_input"><?= $model->getAttributeLabel('discount_date') ?></label>
                <i class="material-icons help-icon" data-hasqtip="8">help</i>
                <div class="hide">
                    <?= Snippet::findByKey('template-hint-discount-date')->value ?>
                </div>
                <div class="push5"></div>
                <?= \yii\jui\DatePicker::widget([
                    'language' => 'ru',
                    'model' => $model,
                    'attribute' => 'discount_date',
                    'dateFormat' => 'dd.MM.yyyy',
                    'options' => [
                        'class' => 'form-control',
                    ],
                    'clientOptions' => [
                        'monthNames' => ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
                        'monthNamesShort' => ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'],
                        'dayNamesMin' => ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
                    ]
                ]) ?>
            </div>

<!--            <div class="form-group">-->
<!--                --><?php //= Html::label("Период действия акции", "template-discount_date", ['class' => 'control-label']) ?>
<!--                --><?php //= Html::tag('i', 'help', ['class' => 'material-icons help-icon']) ?>
<!--                --><?php //= Html::tag('div', Snippet::findByKey('template-hint-discount-date')->value, ['class' => 'hide']) ?>
<!--                --><?php //= kartik\daterange\DateRangePicker::widget([
//                    'model' => $model,
//                    'attribute' => 'discount_date',
//                    'useWithAddon' => false,
//                    'convertFormat' => true,
//                    'options' => [
//                        'value' => $model->discount_start_date && $model->discount_date ? Yii::$app->formatter->asDate($model->discount_start_date, 'dd.MM.yyyy') . ' - ' . Yii::$app->formatter->asDate($model->discount_date, 'dd.MM.yyyy') : '',
//                        'id' => 'template-discount_date',
//                        'class' => 'form-control'
//                    ],
//                    'pluginOptions' => [
//                        'timePicker' => false,
//                        'locale' => [
//                            'format' => 'd.m.Y'
//                        ],
//                        'minDate' => date('Y-m-d', time())
//                    ]
//                ]) ?>
<!--            </div>-->
        </div>
    </div>
    <div class="push5"></div>

<?= $form->field($model, 'is_free', [
    'options' => ['class' => 'customcheck m1'],
    'template' => "{input}\n<label for=\"free_template\">
        <i class=\"material-icons no-checked-icon\">check_box_outline_blank</i>
        <i class=\"material-icons checked-icon\">check_box</i>
        Бесплатный шаблон
    </label><i class=\"material-icons help-icon attention\">announcement</i>
    <div class=\"hide\">
        <b class=\"f18\">Внимание!</b><br/>" . Snippet::findByKey('template-hint-is-free')->value . "
    </div>",
])->checkbox([
    'id' => 'free_template'
], false) ?>

    <!-- скрипт внизу страницы -->
    <div class="push20"></div>
    <div class="row">
        <div class="col-lg-10">
            <?= $form->field($model, 'tag_ids', [
                'template' => "{label}\n<i class=\"material-icons help-icon\">help</i>
                                        <div class=\"hide\">" . Snippet::findByKey('template-hint-tags')->value . "</div>
                                        <div class=\"push5\"></div>\n{input}\n{error}",
            ])->dropDownList(Tag::getTags(\yii\helpers\ArrayHelper::map($model->categories, 'id', 'id')), [
                'class' => 'chosen-select required',
                'data-placeholder' => 'Выберите до 5 меток',
                'data-url' => \yii\helpers\Url::to(['user/template/tags']),
                'multiple' => true,
                'prompt' => '',
            ]) ?>
        </div>
    </div>
    <div class="push20"></div>
    <div class="row">
        <div class="col-lg-10">
            <?= $form->field($model, 'description', [
                'template' => "{label}\n<i class=\"material-icons help-icon\">help</i>
                                        <div class=\"hide\">" . Snippet::findByKey('template-hint-description')->value . "</div>
                                        <div class=\"push5\"></div>\n{input}\n{error}",
            ])->widget(\dosamigos\ckeditor\CKEditor::className(), [
                'options' => ['rows' => 6],
                'preset' => 'basic'
            ]) ?>
            <div class="push10"></div>
        </div>
    </div>

    <div class="push20"></div>
    <div class="row">
        <div class="col-lg-10">
            <?= $form->field($model, 'features', [
                'template' => "{label}\n<i class=\"material-icons help-icon\">help</i>
                                        <div class=\"hide\">" . Snippet::findByKey('template-hint-features')->value . "</div>
                                        <div class=\"push5\"></div>\n{input}\n{error}",
            ])->textarea([
                'class' => 'form-control',
            ]) ?>
            <div class="push10"></div>
        </div>
    </div>

<?php if (!$model->isNewRecord): ?>
    <div class="push20"></div>
    <div class="row">
        <div class="col-lg-10">
            <?= $form->field($model, 'version_history', [
                'template' => "{label}\n<i class=\"material-icons help-icon\">help</i>
                                        <div class=\"hide\">" . Snippet::findByKey('template-hint-version-history')->value . "</div>
                                        <div class=\"push5\"></div>\n{input}\n{error}",
            ])->textarea([
                'class' => 'form-control',
            ]) ?>
            <div class="push10"></div>
        </div>
    </div>
<?php endif; ?>

    <div class="push10"></div>

    <div class="row">
        <div class="col-sm-12 col-lg-5">
            <!-- http://filer.grandesign.md/#documentation -->
            <?= $form->field($model, 'file', [
                'template' => "{label}\n<i class=\"material-icons help-icon\">help</i>
                                        <div class=\"hide\">" . Snippet::findByKey('template-hint-file')->value . "</div>
                                        <div class=\"push5\"></div>\n{input}\n{error}",
            ])->fileInput([
                'class' => 'form-control num',
                'id' => 'filer_input_archive',
            ]) ?>

            <?php if (count($model->files) > 0): ?>
                <a href="#" class="dotted" id="show-previous-uploads">Предыдущие
                    версии</a> (<?= count($model->files) ?> шт.)
                <ul class="previous-uploads" id="previous-uploads">
                    <?php $i = 1; ?>
                    <?php foreach ($model->files as $file): ?>
                        <li>
                            <?= $i ?>) <a
                                    href="<?= \yii\helpers\Url::to(['template/download', 'id' => $model->id, 'fid' => $file->id]) ?>"
                                    class="dotted" target="_blank"><?= Html::encode($file->original_name) ?></a>
                            (<?= Yii::$app->formatter->asShortSize($file->size) ?>)
                        </li>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
    <div class="push20"></div>

    <div class="row">
        <div class="col-lg-10">
            <div class="form-group filer-images-wrapper">
                <label><strong>Загрузить до 4 изображений шаблона</strong></label>
                <i class="material-icons help-icon">help</i>
                <div class="hide">
                    <?= Snippet::findByKey('template-hint-images')->value ?>
                </div>
                <div class="push10"></div>
                <!-- http://filer.grandesign.md/#documentation -->
                <?= $form->field($model, 'images[]')->fileInput([
                    'data-upload-url' => Yii::$app->urlManager->createAbsoluteUrl(['/user/template/upload-files']),
                    'id' => 'filer_input_images',
                    'multiple' => true,
                ])->label(false) ?>

                <script>
                    var FILER_FILES = JSON.parse('<?= $this->context->getFilesJson($model) ?>');
                </script>
            </div>
        </div>
    </div>
    <div class="push20"></div>

    <div class="push20"></div>

    <input type="submit" class="btn big" value="<?= $model->isNewRecord ? 'Загрузить' : 'Сохранить' ?>"/>

<?php ActiveForm::end() ?>
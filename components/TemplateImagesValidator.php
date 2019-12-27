<?php

namespace app\components;

use yii\validators\Validator;
use yii\web\UploadedFile;

/**
 * Class TemplateImagesValidator
 * @package app\components
 */
class TemplateImagesValidator extends Validator
{
    protected $minCountMessage = 'Необходимо загрузить хотя бы одно изображение.';
    protected $maxCountMessage = 'Нельзя загружать более 4-х изображений.';
    protected $maxSizeMessage = 'Нельзя загружать более 10 МБ.';

    /**
     * @inheritdoc
     */
    public function validateAttribute($model, $attribute)
    {
        if (count($model->$attribute) == 0 && $model->isNewRecord) {
            $this->addError($model, $attribute, $this->minCountMessage);
        }

        if (count($model->$attribute) > 4) {
            $this->addError($model, $attribute, $this->maxCountMessage);
        }

        /** @var UploadedFile $item */
        foreach ($model->$attribute as $item) {
            if ($item->size > 10000000) {
                $this->addError($model, $attribute, $this->maxSizeMessage);
                break;
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function clientValidateAttribute($model, $attribute, $view)
    {
        return <<<JS
        if($('.field-filer_input_images .jFiler-item').length == 0) {
            messages.push("{$this->minCountMessage}");
        }
        if($('.field-filer_input_images .jFiler-item').length > 4) {
            messages.push("{$this->maxCountMessage}");
        }
JS;
    }
}
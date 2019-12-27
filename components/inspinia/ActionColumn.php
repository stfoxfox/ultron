<?php

namespace app\components\inspinia;

use Yii;
use yii\helpers\Html;

/**
 * Class ActionColumn
 * @package dekasoft\inspinia
 */
class ActionColumn extends \yii\grid\ActionColumn
{
    /** @inheritdoc */
    public $template = '{update} &nbsp; {delete}';
    /** @inheritdoc */
    public $contentOptions = [
        'class' => 'actions',
    ];

    /** @inheritdoc */
    protected function initDefaultButtons()
    {
        if (!isset($this->buttons['view'])) {
            $this->buttons['view'] = function ($url, $model) {
                return Html::a('<i class="fa fa-eye"></i>', $url, [
                    'title' => Yii::t('yii', 'View'),
                    'data-pjax' => '0',
                ]);
            };
        }

        if (!isset($this->buttons['update'])) {
            $this->buttons['update'] = function ($url, $model) {
                return Html::a('<i class="fa fa-pencil"></i>', $url, [
                    'title' => Yii::t('yii', 'Update'),
                    'data-pjax' => '0',
                ]);
            };
        }

        if (!isset($this->buttons['delete'])) {
            $this->buttons['delete'] = function ($url, $model) {
                return Html::a('<i class="fa fa-trash-o"></i>', $url, [
                    'title' => Yii::t('yii', 'Delete'),
                    'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                    'data-method' => 'post',
                    'data-pjax' => '0',
                ]);
            };
        }

    }
}
<?php

namespace app\components\inspinia;

/**
 * Class GridView
 * @package dekasoft\inspinia
 */
class GridView extends \yii\grid\GridView
{
    /** @inheritdoc */
    public $summary = '';

    /** @inheritdoc */
    public $tableOptions = [
        'class' => 'table table-hover',
    ];

    /** @inheritdoc */
    public $options = [
        'class' => 'grid-view',
    ];

    /** @inheritdoc */
    public $layout = "{items}\n{summary}\n{pager}\n";

    /** @inheritdoc */
    public $pager = [
        'class' => '\app\components\inspinia\LinkPager',
    ];

    /** @inheritdoc */
    public $summaryOptions = [];
}

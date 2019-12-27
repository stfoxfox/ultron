<?php

namespace app\components\inspinia;

/**
 * Class LinkPager
 * @package dekasoft\inspinia
 */
class LinkPager extends \yii\widgets\LinkPager
{
    /** @inheritdoc */
    public $options = [
        'class' => 'pagination pull-right',
    ];
}

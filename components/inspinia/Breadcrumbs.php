<?php

namespace app\components\inspinia;

/**
 * Class Breadcrumbs
 * @package dekasoft\inspinia
 */
class Breadcrumbs extends \yii\widgets\Breadcrumbs
{
    /** @inheritdoc */
    public $tag = 'ol';

    /** @inheritdoc */
    public $encodeLabels = false;

    /** @inheritdoc */
    public $options = ['class' => 'breadcrumb'];

    /** @inheritdoc */
    public $itemTemplate = "<li><span>{link}</span></li>\n";

    /** @inheritdoc */
    public $activeItemTemplate = "<li class=\"active\"><span>{link}</span></li>\n";

    /** @inheritdoc */
    public $homeLink = [
        'label' => '<i class="fa fa-home"></i>',
    ];

    public function run()
    {
        if (!empty($this->homeLink) && empty($this->homeLink['url'])) {
            $this->homeLink['url'] = preg_replace('{^(/.*?)(/|$).*}', '$1',
                $_SERVER['REQUEST_URI']);
        }

        return parent::run();
    }
}
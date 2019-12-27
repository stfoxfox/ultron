<?php

namespace app\widgets\cart;

use app\models\CartForm;
use app\models\Template;

/**
 * Class Order
 * @package app\widgets\news
 */
class Cart extends \yii\base\Widget
{
    /** @var $template Template */
    public $template;

    /**
     * @return string
     */
    public function run()
    {
        $cartForm = new CartForm();
        $cartForm->templateId = $this->template->id;

        return $this->render('view', [
            'template' => $this->template,
            'cartForm' => $cartForm,
        ]);
    }
}
<?php

namespace app\models;

use yz\shoppingcart\ShoppingCart;

/**
 * Class CartForm
 * @package app\models
 */
class CartForm extends \yii\base\Model
{
    public $templateId;
    public $services = [];
    public $options = [];

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['templateId'], 'required'],
            [['services'], 'validateServices'],
            [['options'], 'validateOptions'],
            [['templateId'], 'validateTemplateId'],
        ];
    }

    public function validateOptions()
    {
        // todo: проверить на существование и на возможность применения данной опции к заданному шаблону...
    }

    public function validateServices()
    {
        // todo: проверить на существование и на возможность применения данной услуги к заданному шаблону...
    }

    public function validateTemplateId()
    {
        // todo: проверить на существование...
    }

    /**
     * @return TemplateCartPosition
     */
    private function createCartPosition()
    {
        /** @var TemplateCartPosition $position */
        $position = \Yii::createObject([
            'class' => TemplateCartPosition::className(),
            'id' => $this->templateId,
            'services' => $this->services,
            'options' => $this->options,
        ]);
        return $position;
    }

    /**
     * @return int
     */
    public function addToCart()
    {
        /** @var ShoppingCart $cart */
        $cart = \Yii::$app->cart;

        $position = $this->createCartPosition();
        if ($cart->getPositionById($position->id)) {
            $cart->removeById($position->id);
        }

        $cart->put($position, 1);
        return $cart->count;
    }
}
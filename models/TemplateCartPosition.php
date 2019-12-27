<?php

namespace app\models;

use yii\base\Object;
use yii\db\Expression;
use yz\shoppingcart\CartPositionInterface;

/**
 * Class ProductCartPosition
 * @package app\models
 */
class TemplateCartPosition extends Object implements CartPositionInterface
{
    /**
     * @var Template
     */
    protected $_product;

    public $id;
    public $services = [];
    public $options = [];

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getPrice()
    {
        return $this->getTemplate()->getActualPrice();
    }

    /**
     * @inheritdoc
     */
    public function getCost($withDiscount = true)
    {
        $templateCost = (float)$this->getTemplate()->getActualPrice();
        $servicesCost = (float)$this->getServicesCost();
        $optionsCost = (float)$this->getOptionsCost();

        return $templateCost + $servicesCost + $optionsCost;
    }

    /**
     * @inheritdoc
     */
    public function setQuantity($quantity)
    {

    }

    /**
     * @inheritdoc
     */
    public function getQuantity()
    {
        return 1;
    }

    /**
     * @return Template
     */
    public function getTemplate()
    {
        if ($this->_product === null) {
            $this->_product = Template::findOne($this->id);
        }
        return $this->_product;
    }

    /**
     * @return array|Option[]
     */
    public function getServices()
    {
        if (!$this->services) {
            return [];
        }

        return Service::find()->where([
            'id' => $this->services,
        ])->all();
    }

    /**
     * @return array|Service[]
     */
    public function getOptions()
    {
        if (!$this->options) {
            return [];
        }

        return Option::find()->where([
            'id' => $this->options,
        ])->all();
    }

    /**
     * @return float
     */
    private function getServicesCost()
    {
        $sum = 0;
        foreach ($this->getServices() as $service) {
            $sum += (float)$service->price;
        }
        return $sum;
    }

    /**
     * @return false|null|string
     */
    private function getOptionsCost()
    {
        $sum = 0;
        foreach ($this->getOptions() as $option) {
            $sum += (float)$option->price;
        }
        return $sum;
    }
}
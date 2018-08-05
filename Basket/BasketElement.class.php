<?php
namespace Basket;
class BasketElement
{
    protected $element;
    protected $quantity;
    /**
     * BasketElement constructor.
     * @param $element
     * @param $quantity
     */
    public function __construct(\BasicInfo $element, $quantity = 1)
    {
        $this->element = $element;
        $this->quantity = $quantity;
    }
    public function getElement()
    {
        return $this->element;
    }
    public function getQuantity()
    {
        return $this->quantity;
    }
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }
}
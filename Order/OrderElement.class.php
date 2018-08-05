<?php
namespace Order;
final class OrderElement extends \Basket\BasketElement
{
    private $cost;
    /**
     * BasketElement constructor.
     * @param $element
     * @param $quantity
     */
    public function __construct(\BasicInfo $element, $quantity = 1)
    {
        parent::__construct($element, $quantity);
        $this->cost = $element->getCost();
    }
    public function getCost()
    {
        return $this->cost;
    }
}
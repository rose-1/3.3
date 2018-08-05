<?php
namespace Products;
abstract class Product implements \BasicInfo
{
    protected static $groupDiscount = [];
    protected $name;
    protected $cost;
    protected $color;
    protected $productDiscount;
    protected $productGroup;
    public function __construct($name, $cost, $color)
    {
        $this->name = $name;
        $this->cost = $cost;
        $this->color = $color;
    }
    public function getFullDescription($itemType = true)
    {
        $advName = $itemType ? 'Товар ' : '';
        return $advName . vsprintf(
                "%1\$s %2\$s цвета %3\$s цена %4\$u руб., скидка на всю группу %1\$s - %5\$u процентов, 
          скидка именно на %2\$s - %6\$u процентов.",
                $this->getProductInfo()
            );
    }
    public function getProductInfo()
    {
        $product = [
            $this->getProductGroup(),
            $this->getName(),
            $this->getColor(),
            $this->getCost(),
            self::getGroupDiscount($this->productGroup),
            $this->getProductDiscount()
        ];
        return $product;
    }
    public function getProductGroup()
    {
        return isset($this->productGroup) ? $this->productGroup : '';
    }
    public function setProductGroup($productGroup)
    {
        $this->productGroup = $productGroup;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getColor()
    {
        return $this->color;
    }
    public function setColor($color)
    {
        $this->color = $color;
    }
    /**
     * выводит цену с учетом скидки (выбирается максимальная скидка)
     * @return mixed
     */
    public function getCost()
    {
        $discount = max($this->productDiscount, self::getGroupDiscount($this->productGroup));
        return $this->cost * (1 + $discount / 100);
    }
    public function setCost($cost)
    {
        $this->cost = $cost;
    }
    public static function getGroupDiscount($group)
    {
        return isset(self::$groupDiscount[$group]) ? self::$groupDiscount[$group] : 0;
    }
    public static function setGroupDiscount($group, $discount)
    {
        self::$groupDiscount[$group] = $discount;
    }
    public function getProductDiscount()
    {
        return isset($this->productDiscount) ? $this->productDiscount : 0;
    }
    public function setProductDiscount($productDiscount)
    {
        $this->productDiscount = $productDiscount;
    }
}
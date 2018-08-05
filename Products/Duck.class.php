<?php
namespace Products;
class Duck extends Product
{
    protected $age;
    protected $weight;
    protected $productGroup = 'Утка';
    public function changeWeight($changeWeight)
    {
        $this->weight = (($this->weight + $changeWeight) >= 1) ? ($this->weight + $changeWeight) : 1;
    }
    public function upAge()
    {
        $this->age = ++$this->age;
    }
    public function getFullDescription($itemType = true)
    {
        return parent::getFullDescription() .
            sprintf(" Возраст этой утки %u лет, ее вес %u кг.", $this->getAge(), $this->getWeight());
    }
    public function getAge()
    {
        return $this->age;
    }
    public function setAge($age)
    {
        $this->age = $age;
    }
    public function getWeight()
    {
        return $this->weight;
    }
    public function setWeight($weight)
    {
        $this->weight = $weight;
    }
}
<?php
namespace Products;
class Pen extends Product
{
    protected $thickness;
    protected $inkLevel;
    protected $productGroup = 'Ручка';
    public function usePen()
    {
        $this->inkLevel = $this->inkLevel > 0 ? --$this->inkLevel : 0;
    }
    public function getFullDescription($itemType = true)
    {
        return parent::getFullDescription() .
            sprintf(" У этой ручки толщина стержня %01.1f, уровень чернил %u.", $this->getThickness(),
                $this->getInkLevel());
    }
    public function getThickness()
    {
        return $this->thickness;
    }
    public function setThickness($thickness)
    {
        $this->thickness = $thickness;
    }
    public function getInkLevel()
    {
        return $this->inkLevel;
    }
    public function setInkLevel($inkLevel = 100)
    {
        $this->inkLevel = $inkLevel;
    }
}
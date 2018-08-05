<?php
namespace Products;
class TelevisionSet extends Product
{
    const STATE_OFF = 'выключен';
    const STATE_ON = 'включен';
    protected $state = self::STATE_OFF;
    protected $channel = 1;
    protected $volume = 50;
    protected $productGroup = 'Телевизор';
    public function volumeUp()
    {
        $this->volume = (($this->state === self::STATE_ON) && ($this->volume < 100)) ? ++$this->volume : $this->volume;
    }
    public function volumeDown()
    {
        $this->volume = (($this->state === self::STATE_ON) && ($this->volume > 0)) ? --$this->volume : $this->volume;
    }
    public function turnOn()
    {
        $this->state = self::STATE_ON;
    }
    public function turnOff()
    {
        $this->state = self::STATE_OFF;
    }
    public function getFullDescription($itemType = true)
    {
        return parent::getFullDescription() .
            sprintf(" %s сейчас %s, его громкость %s, канал №%u.", $this->getProductGroup(),
                $this->getState(), $this->getVolume(), $this->getChannel());
    }
    public function getState()
    {
        return $this->state;
    }
    public function getVolume()
    {
        return $this->volume;
    }
    public function getChannel()
    {
        return $this->channel;
    }
    public function setChannel($channel)
    {
        $this->channel = ($this->state === self::STATE_ON) ? $channel : $this->channel;
    }
}